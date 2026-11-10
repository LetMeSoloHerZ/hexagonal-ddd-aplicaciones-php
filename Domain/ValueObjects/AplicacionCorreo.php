<?php

require_once __DIR__ . '/../Exceptions/InvalidAplicacionException.php';

class AplicacionCorreo
{
    const MAX_LENGTH = 120;

    private $value;

    public function __construct($value)
    {
        $normalizedValue = trim((string) $value);

        if ($normalizedValue === '') {
            throw InvalidAplicacionException::becauseFieldIsEmpty('correo');
        }

        if (strlen($normalizedValue) > self::MAX_LENGTH) {
            throw InvalidAplicacionException::becauseFieldIsTooLong('correo', self::MAX_LENGTH);
        }

        if (!filter_var($normalizedValue, FILTER_VALIDATE_EMAIL)) {
            throw InvalidAplicacionException::becauseEmailFormatIsInvalid($normalizedValue);
        }

        $this->value = strtolower($normalizedValue);
    }

    public function value()
    {
        return $this->value;
    }

    public function equals(AplicacionCorreo $other)
    {
        return $this->value === $other->value();
    }

    public function __toString()
    {
        return $this->value;
    }
}
