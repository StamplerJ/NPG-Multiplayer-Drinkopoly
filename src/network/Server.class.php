#!/usr/bin/php
<?php
require("SocketFunctions.util.php");

class Server
{
    private $HOST = "172.18.1.113";
    private $PORT = 22408;
    private $NULL = null;

    private $serverSocket;
    private $clientSockets = array();

    public function __construct()
    {
        $this->serverSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($this->serverSocket, SOL_SOCKET, SO_REUSEADDR, 1);

        socket_bind($this->serverSocket, $this->HOST, $this->PORT);

        if (socket_listen($this->serverSocket))
        {
            echo "Listen on Port " . $this->PORT . "\n";
        }

        while (1)
        {
            $socketsToWatch = $this->clientSockets;
            $socketsToWatch[] = $this->serverSocket;
            $activeSocketsCount = socket_select($socketsToWatch, $this->NULL, $this->NULL, $this->NULL);

            if ($activeSocketsCount === false)
            {
                echo "Error in socket_select";
                die;
            }

            if ($activeSocketsCount == 0)
            {
                continue;
            }

            // Server socket handling
            if (in_array($this->serverSocket, $socketsToWatch))
            {
                $newSocket = socket_accept($this->serverSocket);

                $header = socket_read($newSocket, 1024);
                perform_handshaking($header, $newSocket, $this->HOST, $this->PORT);

                $this->sendWelcomeMessage($newSocket);

                $clientSockets[] = $newSocket;
                $index = array_search($this->serverSocket, $socketsToWatch);
                unset($socketsToWatch[$index]);
            }

            // Client socket handling
            foreach ($socketsToWatch as $socket)
            {
                socket_getpeername($socket, $clientIP);

                $end = false;
                $text = (socket_read($socket, 1024));

                if ($text === false || $text == "")
                {
                    $end = true;
                }
                else
                {
                    $text = unmask($text);
                }

                // Browser closed check
                if (preg_match('/\x03/', $text))
                {
                    $end = true;
                }

                $messageObject = json_decode($text);

                if ($end || (isset($messageObject->message)))
                {
                    $index = array_search($socket, $this->clientSockets);
                    unset($this->clientSockets[$index]);
                    socket_close($socket);

                    echo "Verbindung zu " . $clientIP . "  beendet \n";

                    //Alle anderen Clients informieren:
                    $msg = array('type' => 'system', 'message' => "Client " . $clientIP . "  disconnected");
                    $jsonText = json_encode($msg);
                    send_message($this->clientSockets, mask($jsonText));
                }
                else
                {
                    if (isset($messageObject->message))
                    {
                        //$text=htmlspecialchars("Client ".$clientIP.": ". $messageObject->message);
                        $text = "Client " . $clientIP . ": " . $messageObject->message;
                        echo $text . "\n";
                        //und die erhaltene Nachricht an alle Client zurückschicken:
                        $text = json_encode(array('type' => 'user', 'message' => "Client " . $clientIP . " : " . $messageObject->message));
                        send_message($this->clientSockets, mask($text));
                    }
                }
            }
        }
    }

    private function sendWelcomeMessage($socket)
    {
        socket_getpeername($socket, $clientIP);

        echo "Client " . $clientIP . " connected \n";

        $msg = array('type' => 'system', 'message' => "Verbindung erfolgreich!");
        $jsonMsg = json_encode($msg) ;
        $sendMsg = mask($jsonMsg);
        socket_write($socket, $sendMsg, strlen($sendMsg));

        $msg = array('type' => 'user', 'message' => "Hallo ".$clientIP. ", herzlich willkommen!");
        $jsonMsg = json_encode($msg) ;
        $sendMsg = mask($jsonMsg);
        socket_write($socket, $sendMsg, strlen($sendMsg));

        //Alle anderen Clients informieren:
        $msg = array('type'=>'system', 'message'=>"Neuer Client ".$clientIP." verbunden");
        $jsonText = json_encode($msg) ;
        send_message($this->clientSockets, mask( $jsonText));
    }
}