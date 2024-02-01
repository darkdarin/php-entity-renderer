<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

use DarkDarin\PhpEntityRenderer\Renderers\AttributeRenderer;

/**
 * @psalm-api
 */
interface HasAttributesInterface
{
    public function getAttributes(): array;
    public function addAttribute(AttributeRenderer $attribute): self;
}
