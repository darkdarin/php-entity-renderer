<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

use DarkDarin\PhpEntityRenderer\Renderers\MethodRenderer;

/**
 * @psalm-api
 */
interface HasMethodsInterface
{
    public function getMethods(): array;

    public function addMethod(MethodRenderer $method): self;
}
