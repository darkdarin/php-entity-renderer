<?php

namespace DarkDarin\PhpEntityRenderer\Renderers;

use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Helpers\HasConstants;
use DarkDarin\PhpEntityRenderer\Helpers\HasMethods;
use DarkDarin\PhpEntityRenderer\Helpers\HasProperties;
use DarkDarin\PhpEntityRenderer\Helpers\HasTraits;

class TraitRenderer extends AbstractEntityRenderer
{
    use HasConstants;
    use HasMethods;
    use HasProperties;
    use HasTraits;

    protected function renderHeader(EntityAliases $entityAliases): string
    {
        $result = [];

        $result[] = 'trait';
        $result[] = $this->getBaseClassName();

        return implode(' ', $result);
    }

    protected function renderBody(EntityAliases $entityAliases): string
    {
        $traits = $this->renderTraits();
        $constants = $this->renderConstants($entityAliases);
        $properties = $this->renderProperties($entityAliases);
        $methods = $this->renderMethods($entityAliases);

        return implode(PHP_EOL . PHP_EOL, array_filter([$traits, $constants, $properties, $methods]));
    }
}
