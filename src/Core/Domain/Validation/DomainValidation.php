<?php

namespace Core\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;

class DomainValidation
{
    /**
     * @throws EntityValidationException
     */
    public static function notNull(string $value, string $message = null): void
    {
        if (empty($value))
            throw  new EntityValidationException($message ?? 'Should not be empty or null');
    }

    /**
     * @throws EntityValidationException
     */
    public static function strMaxLength(string $value, int $length = 255, string $message = null): void
    {
        if (strlen($value) >= $length)
            throw  new EntityValidationException($message ?? "The value must not be greater than {$length} characters");

    }

    /**
     * @throws EntityValidationException
     */
    public static function strMinLength(string $value, int $length = 3, string $message = null): void
    {
        if (strlen($value) <= $length)
            throw  new EntityValidationException($message ?? "The value must  be at least {$length} characters");

    }

    /**
     * @throws EntityValidationException
     */
    public static function strCanNullAndMaxLength(string $value, int $length = 255, string $message = null): void
    {
        if (!empty($value) && strlen($value) > $length)
            throw  new EntityValidationException($message ?? "The valeu must not be greater than {$length} characters");
    }
}