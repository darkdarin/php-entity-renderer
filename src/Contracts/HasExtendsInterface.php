<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

use DarkDarin\PhpEntityRenderer\EntityAliases;

/**
 * @psalm-api
 */
interface HasExtendsInterface
{
    public function getExtends(): ?string;

    /**
     * @param EntityAliases $entityAliases
     * @param class-string $className
     * @return $this
     */
    public function setExtends(EntityAliases $entityAliases, string $className): self;
}
