<?php

namespace DarkDarin\PhpEntityRenderer\Renderers\Types;

use DarkDarin\PhpEntityRenderer\Contracts\TypeRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;

readonly class UnionTypeRenderer implements TypeRendererInterface
{
    /** @var list<TypeRendererInterface> */
    public array $types;

    public function __construct(TypeRendererInterface ...$types)
    {
        $nullable = $this->hasNullableTypes($types);
        $this->types = $this->getTypesWithNullable($types, $nullable);
    }

    public function renderDocBlock(EntityAliases $entityAliases): string
    {
        return $this->render($entityAliases);
    }

    public function render(EntityAliases $entityAliases): string
    {
        return implode(
            '|',
            array_map(
                fn (TypeRendererInterface $type) => $type instanceof IntersectTypeRenderer
                    ? '(' . $type->render($entityAliases) . ')'
                    : $type->render($entityAliases),
                $this->types
            )
        );
    }

    public function setNullable(bool $nullable = true): TypeRendererInterface
    {
        if ($nullable === $this->isNullable()) {
            return $this;
        }

        return new self(...$this->getTypesWithNullable($this->types, $nullable));
    }

    public function isNullable(): bool
    {
        return $this->hasNullableTypes($this->types);
    }

    /**
     * @param list<TypeRendererInterface> $types
     * @return list<TypeRendererInterface>
     */
    private function getTypesWithNullable(array $types, bool $nullable): array
    {
        $types = $this->filterNullable($types);
        if ($nullable) {
            $types[] = BuiltinTypeRenderer::Null;
        }

        return $types;
    }

    /**
     * @param list<TypeRendererInterface> $types
     * @return list<TypeRendererInterface>
     */
    private function filterNullable(array $types): array
    {
        $result = [];
        foreach ($types as $type) {
            if ($type === BuiltinTypeRenderer::Null) {
                continue;
            }

            $result[] = $type->setNullable(false);
        }

        return $result;
    }

    private function hasNullableTypes(array $types): bool
    {
        return array_reduce(
            $types,
            fn (bool $carry, TypeRendererInterface $item) => $carry || $item->isNullable(),
            false
        );
    }
}
