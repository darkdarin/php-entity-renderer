<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

use DarkDarin\PhpEntityRenderer\Renderers\ConstantRenderer;

/**
 * @psalm-api
 */
interface HasConstantsInterface
{
    public function getConstants(): array;

    public function addConstant(ConstantRenderer $constant): self;
}
