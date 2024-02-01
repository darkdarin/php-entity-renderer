<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

use DarkDarin\PhpEntityRenderer\EntityAliases;

/**
 * @psalm-api
 */
interface HasImplementsInterface
{
    public function getImplements(): array;

    /**
     * @param EntityAliases $entityAliases
     * @param class-string ...$classNames
     * @return $this
     */
    public function addImplements(EntityAliases $entityAliases, string ...$classNames): self;
}
