<?php
class Book
{
    protected $id, $author, $title;

    function __construct($id, $author, $title)
    {
        $this->id = $id;
        $this->author = $author;
        $this->title = $title;
    }

    function __get($property)
    {
        if(property_exists($this, $property))
        return $this->$property;
    }

    function __set($property, $value)
    {
        if(property_exists($this, $property))
            $this->$property = $value;

            return $this;
    }
}
?>
