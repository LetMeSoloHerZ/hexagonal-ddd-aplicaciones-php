<?php

require_once __DIR__ . '/../Exceptions/InvalidAplicacionException.php';

/**
 * Tamano del instalador expresado en megabytes (MB).
 */
class TamanoInstalador
{
    const MAX_VALUE = 99999999.99;

    private $value;

    public function __construct($value)
    {
        if (is_string($value)) {
            $value = trim($value);
        }

        if ($value === '' || $value === null || !is_numeric($value)) {
            throw InvalidAplicacionException::becauseInstallerSizeIsInvalid((string) $value);
        }

        $number = round((float) $value, 2);

        if ($number <= 0 || $number > self::MAX_VALUE) {
            throw InvalidAplicacionException::becauseInstallerSizeIsInvalid((string) $value);
        }

        $this->value = $number;
    }

    public function value()
    {
        return $this->value;
    }

    public function equals(TamanoInstalador $other)
    {
        return $this->value === $other->value();
    }

    public function __toString()
    {
        return number_format($this->value, 2, '.', '') . ' MB';
    }
}
