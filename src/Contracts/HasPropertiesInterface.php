<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

use DarkDarin\PhpEntityRenderer\Renderers\PropertyRenderer;

/**
 * @psalm-api
 */
interface HasPropertiesInterface
{
    public function getProperties(): array;

    public function getDynamicProperties(): array;

    public function addProperty(PropertyRenderer $property): self;

    public function addDynamicProperty(PropertyRenderer $property): self;
}
