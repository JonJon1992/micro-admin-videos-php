<?php

namespace Core\Domain\Entity\Trait;

use Exception;

trait MethodsMagicsTrait
{

    /**
     * @throws Exception
     */
    public function __get($props)
    {
        if (isset($this->{$props}))
            return $this->{$props};

        $className = get_class($this);

        throw  new Exception("Property {$props} not found in class {$className}");
    }

    public function id(): string
    {
        return (string)$this->id;
    }

    public function createdAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }
}