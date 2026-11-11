<?php

class AplicacionNotFoundException extends DomainException
{
    public static function becauseIdWasNotFound($id)
    {
        return new self('The application with id ' . $id . ' was not found.');
    }
}
