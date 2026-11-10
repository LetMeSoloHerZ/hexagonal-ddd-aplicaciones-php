<?php

class InvalidAplicacionException extends InvalidArgumentException
{
    public static function becauseFieldIsEmpty($field)
    {
        return new self('The field ' . $field . ' must not be empty.');
    }

    public static function becauseFieldIsTooShort($field, $minLength)
    {
        return new self('The field ' . $field . ' must contain at least ' . $minLength . ' characters.');
    }

    public static function becauseFieldIsTooLong($field, $maxLength)
    {
        return new self('The field ' . $field . ' must not exceed ' . $maxLength . ' characters.');
    }

    public static function becauseIdFormatIsInvalid($value)
    {
        return new self('The application id ' . $value . ' is not a valid UUID.');
    }

    public static function becauseEmailFormatIsInvalid($value)
    {
        return new self('The email ' . $value . ' does not have a valid format.');
    }

    public static function becauseWebFormatIsInvalid($value)
    {
        return new self('The web address ' . $value . ' must be a valid http or https URL.');
    }

    public static function becausePriceIsInvalid($value)
    {
        return new self('The price ' . $value . ' must be a number greater than or equal to zero.');
    }

    public static function becauseInstallerSizeIsInvalid($value)
    {
        return new self('The installer size ' . $value . ' must be a number greater than zero.');
    }

    public static function becauseBitsAreInvalid($value)
    {
        return new self('The number of bits ' . $value . ' is invalid. Allowed values: 32, 64.');
    }

    public static function becauseValueIsNotAllowed($field, $value, array $allowed)
    {
        return new self(
            'The value ' . $value . ' is not valid for ' . $field . '. Allowed values: ' . implode(', ', $allowed) . '.'
        );
    }

    public static function becauseSecondaryLanguageEqualsPrimary($language)
    {
        return new self('The secondary language must be different from the primary language (' . $language . ').');
    }

    public static function becauseLicenseRequiresZeroPrice($license)
    {
        return new self('A ' . $license . ' license requires the price to be zero.');
    }

    public static function becauseLicenseRequiresPositivePrice($license)
    {
        return new self('A ' . $license . ' license requires a price greater than zero.');
    }
}
