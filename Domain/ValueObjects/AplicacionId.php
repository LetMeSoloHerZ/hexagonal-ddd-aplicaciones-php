<?php

require_once __DIR__ . '/../Exceptions/InvalidAplicacionException.php';

class AplicacionId
{
    private $value;

    public function __construct($value)
    {
        $normalizedValue = strtolower(trim((string) $value));

        if ($normalizedValue === '') {
            throw InvalidAplicacionException::becauseFieldIsEmpty('id');
        }

        if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $normalizedValue)) {
            throw InvalidAplicacionException::becauseIdFormatIsInvalid($normalizedValue);
        }

        $this->value = $normalizedValue;
    }

    public function value()
    {
        return $this->value;
    }

    public function equals(AplicacionId $other)
    {
        return $this->value === $other->value();
    }

    public function __toString()
    {
        return $this->value;
    }
}
