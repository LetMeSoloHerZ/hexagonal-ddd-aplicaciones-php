<?php

require_once __DIR__ . '/../Exceptions/InvalidAplicacionException.php';

class AplicacionWeb
{
    const MAX_LENGTH = 255;

    private $value;

    public function __construct($value)
    {
        $normalizedValue = trim((string) $value);

        if ($normalizedValue === '') {
            throw InvalidAplicacionException::becauseFieldIsEmpty('web');
        }

        if (strlen($normalizedValue) > self::MAX_LENGTH) {
            throw InvalidAplicacionException::becauseFieldIsTooLong('web', self::MAX_LENGTH);
        }

        $scheme = strtolower((string) parse_url($normalizedValue, PHP_URL_SCHEME));

        if (!filter_var($normalizedValue, FILTER_VALIDATE_URL) || !in_array($scheme, array('http', 'https'), true)) {
            throw InvalidAplicacionException::becauseWebFormatIsInvalid($normalizedValue);
        }

        $this->value = $normalizedValue;
    }

    /**
     * Devuelve null cuando el valor viene vacio (la web es opcional).
     */
    public static function fromNullable($value)
    {
        $normalizedValue = trim((string) $value);

        return $normalizedValue === '' ? null : new self($normalizedValue);
    }

    public function value()
    {
        return $this->value;
    }

    public function equals(AplicacionWeb $other)
    {
        return $this->value === $other->value();
    }

    public function __toString()
    {
        return $this->value;
    }
}
