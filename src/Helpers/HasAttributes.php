<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Renderers\AttributeRenderer;

trait HasAttributes
{
    /** @var list<AttributeRenderer> */
    private array $attributes = [];

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function addAttribute(AttributeRenderer $attribute): self
    {
        $this->attributes[] = $attribute;

        return $this;
    }

    private function renderAttributes(EntityAliases $entityAliases, bool $inline = false): string
    {
        $attributes = array_map(
            fn (AttributeRenderer $attribute) => $attribute->render($entityAliases),
            $this->attributes
        );

        if ($inline) {
            return implode(' ', $attributes);
        }
        return implode(PHP_EOL, $attributes);
    }
}
