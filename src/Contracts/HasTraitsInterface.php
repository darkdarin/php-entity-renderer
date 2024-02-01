<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

use DarkDarin\PhpEntityRenderer\EntityAliases;

/**
 * @psalm-api
 */
interface HasTraitsInterface
{
    public function getTraits(): array;

    /**
     * @param EntityAliases $entityAliases
     * @param class-string ...$classNames
     * @return $this
     */
    public function addTraits(EntityAliases $entityAliases, string ...$classNames): self;
}
