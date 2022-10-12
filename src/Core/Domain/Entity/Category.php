<?php

namespace Core\Domain\Entity;


use Core\Domain\Entity\Trait\MethodsMagicsTrait;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use Core\Domain\ValueObject\Uuid;
use DateTime;
use Exception;


class Category
{

    use MethodsMagicsTrait;

    /**
     * @throws Exception
     */
    public function __construct(
        protected Uuid|string     $id = '',
        protected string          $name = '',
        protected string          $description = '',
        protected bool            $isActive = true,
        protected DateTime|string $createdAt = ''
    )
    {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->createdAt = $this->createdAt ? new DateTime($this->createdAt) : new DateTime();
        $this->validate();
    }

    /**
     * @throws EntityValidationException
     */
    public function update(string $name, string $description = ''): void
    {
        $this->name = $name;
        $this->description = $description;
        $this->validate();
    }

    public function activate(): void
    {
        $this->isActive = true;
    }

    public function disable(): void
    {
        $this->isActive = false;
    }

    /**
     * @throws EntityValidationException
     */
    protected function validate(): void
    {
        DomainValidation::strMaxLength($this->name);
        DomainValidation::strMinLength($this->name);
        DomainValidation::strCanNullAndMaxLength($this->description);
    }
}