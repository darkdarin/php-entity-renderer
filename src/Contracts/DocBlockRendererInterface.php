<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

use DarkDarin\PhpEntityRenderer\EntityAliases;

/**
 * @psalm-api
 */
interface DocBlockRendererInterface
{
    public function renderDocBlock(EntityAliases $entityAliases): string;
}
