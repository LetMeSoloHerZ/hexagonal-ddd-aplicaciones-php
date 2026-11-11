<?php

class AplicacionAlreadyExistsException extends DomainException
{
    public static function becauseNameAlreadyExists($name)
    {
        return new self('An application named ' . $name . ' already exists.');
    }
}
