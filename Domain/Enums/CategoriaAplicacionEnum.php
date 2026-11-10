<?php

require_once __DIR__ . '/../Exceptions/InvalidAplicacionException.php';

class CategoriaAplicacionEnum
{
    const EDUCACION = 'EDUCACION';
    const PRODUCTIVIDAD = 'PRODUCTIVIDAD';
    const JUEGOS = 'JUEGOS';
    const UTILIDADES = 'UTILIDADES';
    const DESARROLLO = 'DESARROLLO';
    const COMUNICACION = 'COMUNICACION';
    const MULTIMEDIA = 'MULTIMEDIA';
    const OTRA = 'OTRA';

    public static function values()
    {
        return array(
            self::EDUCACION,
            self::PRODUCTIVIDAD,
            self::JUEGOS,
            self::UTILIDADES,
            self::DESARROLLO,
            self::COMUNICACION,
            self::MULTIMEDIA,
            self::OTRA
        );
    }

    public static function isValid($value)
    {
        return in_array($value, self::values(), true);
    }

    public static function ensureIsValid($value)
    {
        if (!self::isValid($value)) {
            throw InvalidAplicacionException::becauseValueIsNotAllowed('categoria', $value, self::values());
        }
    }
}
