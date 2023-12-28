<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

use DarkDarin\PhpEntityRenderer\EntityAliases;

trait HasImplements
{
    /** @var list<string> */
    private array $implements = [];

    public function getImplements(): array
    {
        return $this->implements;
    }

    public function addImplements(EntityAliases $entityAliases, string ...$classNames): self
    {
        foreach ($classNames as $className) {
            $this->implements[] = $entityAliases->addAlias($className);
        }

        return $this;
    }
}
