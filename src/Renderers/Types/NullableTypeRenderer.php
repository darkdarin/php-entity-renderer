<?php

namespace DarkDarin\PhpEntityRenderer\Renderers\Types;

use DarkDarin\PhpEntityRenderer\Contracts\TypeRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;

readonly class NullableTypeRenderer implements TypeRendererInterface
{
    public function __construct(
        public TypeRendererInterface $type
    ) {}

    public function renderDocBlock(EntityAliases $entityAliases): string
    {
        return $this->type->renderDocBlock($entityAliases) . '|null';
    }

    public function render(EntityAliases $entityAliases): string
    {
        return '?' . $this->type->render($entityAliases);
    }

    public function setNullable(bool $nullable = true): TypeRendererInterface
    {
        if ($nullable) {
            return $this;
        }

        return $this->type;
    }

    public function isNullable(): bool
    {
        return true;
    }
}
