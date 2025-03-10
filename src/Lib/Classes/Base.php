<?php

namespace Application\Lib\Classes;

abstract class Base // Class Base is used for all the similar code between others classes
{
    protected int $id;

    public function get(string $name) // Method which return the value of propertie named in argument
    {
        if(!isset($this->{$name})) // Verify if the named propertie is set
        {
            throw new \LogicException('Erreur logique : la propriété "'.$name.'" n\'existe pas'); //If propertie isn't set, code throw a LogicException
        }

        return $this->{$name}; // If propertie is set, code return the value of it  
    }

}
