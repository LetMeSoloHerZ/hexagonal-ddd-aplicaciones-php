<?php

require_once __DIR__ . '/../Exceptions/InvalidAplicacionException.php';

class SistemaOperativoEnum
{
    const WINDOWS = 'WINDOWS';
    const LINUX = 'LINUX';
    const MACOS = 'MACOS';
    const ANDROID = 'ANDROID';
    const IOS = 'IOS';
    const MULTIPLATAFORMA = 'MULTIPLATAFORMA';

    public static function values()
    {
        return array(
            self::WINDOWS,
            self::LINUX,
            self::MACOS,
            self::ANDROID,
            self::IOS,
            self::MULTIPLATAFORMA
        );
    }

    public static function isValid($value)
    {
        return in_array($value, self::values(), true);
    }

    public static function ensureIsValid($value)
    {
        if (!self::isValid($value)) {
            throw InvalidAplicacionException::becauseValueIsNotAllowed('sistemaOperativo', $value, self::values());
        }
    }
}
