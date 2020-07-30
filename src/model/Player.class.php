<?php


class Player
{
    private $name;
    private $fieldIndex;
    private $color;

    public function __construct($name, $fieldIndex, $color)
    {
        $this->name = $name;
        $this->fieldIndex = $fieldIndex;
        $this->color = $color;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getFieldIndex()
    {
        return $this->fieldIndex;
    }

    public function setFieldIndex($fieldIndex)
    {
        $this->fieldIndex = $fieldIndex;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }
}