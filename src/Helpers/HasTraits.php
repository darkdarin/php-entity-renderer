<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

use DarkDarin\PhpEntityRenderer\EntityAliases;

trait HasTraits
{
    /** @var list<string> */
    private array $traits = [];

    public function getTraits(): array
    {
        return $this->traits;
    }

    /**
     * @param EntityAliases $entityAliases
     * @param class-string ...$classNames
     * @return $this
     */
    public function addTraits(EntityAliases $entityAliases, string ...$classNames): self
    {
        foreach ($classNames as $className) {
            $this->traits[] = $entityAliases->addAlias($className);
        }

        return $this;
    }

    private function renderTraits(): string
    {
        $traits = array_map(
            fn(string $trait) => 'use ' . $trait . ';',
            $this->traits
        );

        return implode(PHP_EOL, $traits);
    }
}
