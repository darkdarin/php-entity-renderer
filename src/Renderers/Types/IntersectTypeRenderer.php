<?php

namespace DarkDarin\PhpEntityRenderer\Renderers\Types;

use DarkDarin\PhpEntityRenderer\Contracts\TypeRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;

readonly class IntersectTypeRenderer implements TypeRendererInterface
{
    /** @var list<TypeRendererInterface> */
    public array $types;

    public function __construct(TypeRendererInterface ...$types)
    {
        $this->types = $types;
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
                fn (TypeRendererInterface $type) => $type instanceof UnionTypeRenderer ? '(' . $type->render($entityAliases) . ')' : $type->render($entityAliases),
                $this->types
            )
        );
    }
}
