<?php

require_once __DIR__ . '/../Exceptions/InvalidAplicacionException.php';

class Precio
{
    const MAX_VALUE = 99999999.99;

    private $value;

    public function __construct($value)
    {
        if (is_string($value)) {
            $value = trim($value);
        }

        if ($value === '' || $value === null || !is_numeric($value)) {
            throw InvalidAplicacionException::becausePriceIsInvalid((string) $value);
        }

        $number = round((float) $value, 2);

        if ($number < 0 || $number > self::MAX_VALUE) {
            throw InvalidAplicacionException::becausePriceIsInvalid((string) $value);
        }

        $this->value = $number;
    }

    public function value()
    {
        return $this->value;
    }

    public function isZero()
    {
        return $this->value == 0.0;
    }

    public function equals(Precio $other)
    {
        return $this->value === $other->value();
    }

    public function __toString()
    {
        return number_format($this->value, 2, '.', '');
    }
}
