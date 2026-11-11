<?php

require_once __DIR__ . '/../Exceptions/InvalidAplicacionException.php';

class LicenciaEnum
{
    const GRATUITA = 'GRATUITA';
    const OPEN_SOURCE = 'OPEN_SOURCE';
    const COMERCIAL = 'COMERCIAL';
    const SHAREWARE = 'SHAREWARE';
    const FREEMIUM = 'FREEMIUM';

    public static function values()
    {
        return array(
            self::GRATUITA,
            self::OPEN_SOURCE,
            self::COMERCIAL,
            self::SHAREWARE,
            self::FREEMIUM
        );
    }

    public static function isValid($value)
    {
        return in_array($value, self::values(), true);
    }

    public static function ensureIsValid($value)
    {
        if (!self::isValid($value)) {
            throw InvalidAplicacionException::becauseValueIsNotAllowed('licencia', $value, self::values());
        }
    }
}
