#!/usr/bin/php
<?php
require_once("MessageHandler.class.php");
require_once("SocketFunctions.util.php");
require_once("UserSocket.class.php");

class Server
{
    private $HOST = "172.18.1.113";
    private $PORT = 22408;
    private $NULL = null;

    private $SERVER_USERNAME = 'Server';

    private $serverSocket;
    private $clients = array();

    private $messageHandler;

    public function __construct()
    {
        $this->serverSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($this->serverSocket, SOL_SOCKET, SO_REUSEADDR, 1);

        socket_bind($this->serverSocket, $this->HOST, $this->PORT);

        $this->messageHandler = new MessageHandler($this);

        if (socket_listen($this->serverSocket))
        {
            echo "Listen on Port " . $this->PORT . "\n";
        }

        while (true)
        {
            $socketsToWatch = array();
            foreach ($this->clients as $client) {
                $socketsToWatch[] = $client->getSocket();
            }
            $socketsToWatch[] = $this->serverSocket;
            $activeSocketsCount = socket_select($socketsToWatch, $this->NULL, $this->NULL, $this->NULL);

            if ($activeSocketsCount === false)
            {
                echo "Error in socket_select";
                die;
            }

            if ($activeSocketsCount == 0)
            {
                echo "Continue";
                continue;
            }

            // Server socket handling
            if (in_array($this->serverSocket, $socketsToWatch))
            {
                $newSocket = socket_accept($this->serverSocket);

                $header = socket_read($newSocket, 1024);
                perform_handshaking($header, $newSocket, $this->HOST, $this->PORT);

                $this->sendWelcomeMessage($newSocket);

                $this->clients[] = new UserSocket($newSocket);
                $index = array_search($this->serverSocket, $socketsToWatch);
                unset($socketsToWatch[$index]);
            }

            // Client socket handling
            $clientsToWatch = array();
            foreach ($this->clients as $client) {
                foreach ($socketsToWatch as $socket) {
                    if($socket == $client->getSocket())
                        $clientsToWatch[] = $client;
                }
            }

            foreach ($clientsToWatch as $client)
            {
                socket_getpeername($client->getSocket(), $clientIP);

                $end = false;
                $text = socket_read($client->getSocket(), 1024);

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

                if ($end)
                {
                    $this->removeSocket($clientIP, $client);
                }
                else
                {
                    if (isset($messageObject->value))
                    {
                        $this->messageHandler->handleMessage($client, $messageObject);
                    }
                }
            }
        }
    }

    public function sendTextToAllClients($username, $text) {
        $message = array('type' => 'chat',
                'value' => array(
                    'username' => $username,
                    'message' => $text
                ));

        $encoded = json_encode($message);
        send_message($this->clients, mask($encoded));
    }

    public function sendMessage($socket, $message) {
        $jsonMsg = json_encode($message) ;
        $sendMsg = mask($jsonMsg);
        socket_write($socket, $sendMsg, strlen($sendMsg));
    }

    public function sendMessageToAllClients($message) {
        $encoded = json_encode($message);
        send_message($this->clients, mask($encoded));
    }

    private function sendWelcomeMessage($socket)
    {
        socket_getpeername($socket, $clientIP);

        echo "Client " . $clientIP . " connected \n";

//        $msg = array('type' => 'chat',
//            'value' => array(
//                'username' => $this->SERVER_USERNAME,
//                'message' => "Verbindung erfolgreich!"
//            ));
//        $this->sendMessage($socket, $msg);
//
//        $msg = array('type' => 'chat',
//            'value' => array(
//                'username' => $this->SERVER_USERNAME,
//                'message' => "Hallo ".$clientIP. ", herzlich willkommen!"
//            ));
//        $this->sendMessage($socket, $msg);
//
//        //Alle anderen Clients informieren:
//        $this->sendTextToAllClients($this->SERVER_USERNAME, "Neuer Client ".$clientIP." verbunden");
    }

    private function removeSocket($clientIP, $client) {
        echo "Verbindung zu " . $clientIP . "  beendet \n";

        $index = array_search($client, $this->clients);

        //Alle anderen Clients informieren:
        $msg = array('username' => 'Server', 'message' => "User " . $this->clients[$index]->getUsername() . "  disconnected");
        $jsonText = json_encode($msg);
        send_message($this->clients, mask($jsonText));

        $this->messageHandler->removePlayer($this->clients[$index]->getUsername());

        // Remove socket
        socket_close($client->getSocket());
        unset($this->clients[$index]);
        $this->clients = array_values($this->clients);

        // End game if all players left
        if(count($this->clients) == 0) {
            $this->messageHandler->getGameManager()->stopGame();
        }
    }

    public function findClient($username) {
        foreach ($this->clients as $client) {
            if($client->getUsername() == $username)
                return $client;
        }
        $this->clients[0];
    }

    public function getClients()
    {
        return $this->clients;
    }

    public function setClients($clients)
    {
        $this->clients = $clients;
    }
}