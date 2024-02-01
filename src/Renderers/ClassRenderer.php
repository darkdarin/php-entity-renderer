<?php

namespace DarkDarin\PhpEntityRenderer\Renderers;

use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Helpers\HasConstants;
use DarkDarin\PhpEntityRenderer\Helpers\HasExtends;
use DarkDarin\PhpEntityRenderer\Helpers\HasImplements;
use DarkDarin\PhpEntityRenderer\Helpers\HasMethods;
use DarkDarin\PhpEntityRenderer\Helpers\HasModifierInheritance;
use DarkDarin\PhpEntityRenderer\Helpers\HasModifierReadonly;
use DarkDarin\PhpEntityRenderer\Helpers\HasProperties;
use DarkDarin\PhpEntityRenderer\Helpers\HasTraits;

class ClassRenderer extends AbstractEntityRenderer
{
    use HasConstants;
    use HasExtends;
    use HasImplements;
    use HasMethods;
    use HasModifierInheritance;
    use HasModifierReadonly;
    use HasProperties;
    use HasTraits;

    protected function renderHeader(EntityAliases $entityAliases): string
    {
        $result = [];
        $modifiers = $this->renderModifiers();
        if (!empty($modifiers)) {
            $result[] = $modifiers;
        }

        $result[] = 'class';
        $result[] = $this->getBaseClassName();

        if ($this->extends !== null) {
            $result[] = 'extends';
            $result[] = $this->extends;
        }

        if (!empty($this->implements)) {
            $result[] = 'implements';
            $result[] = implode(', ', $this->implements);
        }

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
