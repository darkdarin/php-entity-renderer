<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

use DarkDarin\PhpEntityRenderer\EntityAliases;

/**
 * @psalm-api
 */
interface EntityRendererInterface
{
    public function render(EntityAliases $entityAliases): string;
}
