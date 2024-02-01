<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Renderers\DocBlockRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\PropertyRenderer;

trait HasProperties
{
    /** @var list<PropertyRenderer> */
    private array $properties = [];
    /** @var list<PropertyRenderer> */
    private array $dynamicProperties = [];

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getDynamicProperties(): array
    {
        return $this->dynamicProperties;
    }

    public function addProperty(PropertyRenderer $property): self
    {
        $this->properties[] = $property;

        return $this;
    }

    public function addDynamicProperty(PropertyRenderer $property): self
    {
        $this->dynamicProperties[] = $property;

        return $this;
    }

    protected function renderProperties(EntityAliases $entityAliases): string
    {
        $properties = array_map(
            fn(PropertyRenderer $property) => $property->render($entityAliases),
            $this->properties
        );

        return implode(PHP_EOL, $properties);
    }

    protected function renderDynamicProperties(EntityAliases $entityAliases, DocBlockRenderer $docBlock): void
    {
        foreach ($this->dynamicProperties as $property) {
            $docBlock->addLine('@property ' . $property->renderDocBlock($entityAliases));
        }
    }
}
