<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Renderers\ClassRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\InterfaceRenderer;

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
