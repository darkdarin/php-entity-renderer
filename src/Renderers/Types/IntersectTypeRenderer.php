<?php

namespace DarkDarin\PhpEntityRenderer\Renderers\Types;

use DarkDarin\PhpEntityRenderer\Contracts\TypeRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;

/**
 * @psalm-api
 */
readonly class IntersectTypeRenderer implements TypeRendererInterface
{
    /** @var list<ClassTypeRenderer | (UnionTypeRenderer & TypeRendererInterface)> */
    public array $types;

    public function __construct(ClassTypeRenderer | (UnionTypeRenderer & TypeRendererInterface) ...$types)
    {
        $this->types = array_values($types);
    }

    public function renderDocBlock(EntityAliases $entityAliases): string
    {
        return $this->render($entityAliases);
    }

    public function render(EntityAliases $entityAliases): string
    {
        return implode(
            '&',
            array_map(
                fn(TypeRendererInterface $type) => $type instanceof UnionTypeRenderer ? '(' . $type->render($entityAliases) . ')' : $type->render($entityAliases),
                $this->types
            )
        );
    }

    public function setNullable(bool $nullable = true): TypeRendererInterface
    {
        return $this;
    }

    public function isNullable(): bool
    {
        return false;
    }
}
