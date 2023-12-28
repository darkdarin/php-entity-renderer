<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

use DarkDarin\PhpEntityRenderer\EntityAliases;

interface EntityRendererInterface
{
    public function render(EntityAliases $entityAliases): string;
}
