<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

use DarkDarin\PhpEntityRenderer\EntityAliases;

trait HasExtends
{
    private ?string $extends = null;

    public function getExtends(): ?string
    {
        return $this->extends;
    }

    /**
     * @param EntityAliases $entityAliases
     * @param class-string $className
     * @return $this
     */
    public function setExtends(EntityAliases $entityAliases, string $className): self
    {
        $this->extends = $entityAliases->addAlias($className);

        return $this;
    }
}
