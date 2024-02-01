<?php

namespace DarkDarin\PhpEntityRenderer\Renderers\Types;

use DarkDarin\PhpEntityRenderer\Contracts\TypeRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;

readonly class ClassTypeRenderer implements TypeRendererInterface
{
    public function __construct(
        public string $className
    ) {}

    public function renderDocBlock(EntityAliases $entityAliases): string
    {
        return $this->render($entityAliases);
    }

    public function render(EntityAliases $entityAliases): string
    {
        return $entityAliases->addAlias($this->className);
    }

    public function setNullable(bool $nullable = true): TypeRendererInterface
    {
        if ($nullable) {
            return new NullableTypeRenderer($this);
        }

        return $this;
    }

    public function isNullable(): bool
    {
        return false;
    }
}
