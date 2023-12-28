<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

use DarkDarin\PhpEntityRenderer\EntityAliases;

interface DocBlockRendererInterface
{
    public function renderDocBlock(EntityAliases $entityAliases): string;
}
