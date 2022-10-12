<?php

namespace Core\Domain\ValueObject;

use http\Exception\InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    public function __construct(protected string $value)
    {
        $this->ensureIsValid($this->value);
    }

    public static function random(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    public function ensureIsValid(string $id): void
    {
        if (!RamseyUuid::isValid($id))
            throw  new InvalidArgumentException(sprintf('<%> does not allow te value <%>.', static::class, $id));
    }

    public function __toString(): string
    {
        return $this->value;
    }
}