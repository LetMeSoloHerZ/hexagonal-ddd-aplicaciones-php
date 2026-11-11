<?php

require_once __DIR__ . '/../Exceptions/InvalidAplicacionException.php';

class AplicacionNombre
{
    const MIN_LENGTH = 2;
    const MAX_LENGTH = 100;

    private $value;

    public function __construct($value)
    {
        $normalizedValue = trim((string) $value);

        if ($normalizedValue === '') {
            throw InvalidAplicacionException::becauseFieldIsEmpty('nombre');
        }

        if (mb_strlen($normalizedValue) < self::MIN_LENGTH) {
            throw InvalidAplicacionException::becauseFieldIsTooShort('nombre', self::MIN_LENGTH);
        }

        if (mb_strlen($normalizedValue) > self::MAX_LENGTH) {
            throw InvalidAplicacionException::becauseFieldIsTooLong('nombre', self::MAX_LENGTH);
        }

        $this->value = $normalizedValue;
    }

    public function value()
    {
        return $this->value;
    }

    public function equals(AplicacionNombre $other)
    {
        return $this->value === $other->value();
    }

    public function __toString()
    {
        return $this->value;
    }
}
