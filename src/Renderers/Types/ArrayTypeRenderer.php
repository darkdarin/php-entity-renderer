<?php

namespace DarkDarin\PhpEntityRenderer\Renderers\Types;

use DarkDarin\PhpEntityRenderer\Contracts\TypeRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;

readonly class ArrayTypeRenderer implements TypeRendererInterface
{
    public function __construct(
        public TypeRendererInterface $valueType = BuiltinTypeRenderer::Mixed,
        public ?BuiltinTypeRenderer $keyType = null,
    ) {
    }

    public function renderDocBlock(EntityAliases $entityAliases): string
    {
        if ($this->valueType === BuiltinTypeRenderer::Mixed && $this->keyType === null) {
            return 'array';
        }
        if ($this->keyType === null) {
            return sprintf('list<%s>', $this->valueType->render($entityAliases));
        }

        return sprintf(
            'array<%s, %s>',
            $this->keyType->render($entityAliases),
            $this->valueType->render($entityAliases)
        );
    }

    public function render(EntityAliases $entityAliases): string
    {
        return 'array';
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
