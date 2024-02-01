<?php

namespace DarkDarin\PhpEntityRenderer\Renderers;

use DarkDarin\PhpEntityRenderer\Contracts\HasConstantsInterface;
use DarkDarin\PhpEntityRenderer\Contracts\HasExtendsInterface;
use DarkDarin\PhpEntityRenderer\Contracts\HasMethodsInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Helpers\HasConstants;
use DarkDarin\PhpEntityRenderer\Helpers\HasExtends;
use DarkDarin\PhpEntityRenderer\Helpers\HasMethods;

/**
 * @psalm-api
 */
class InterfaceRenderer extends AbstractEntityRenderer implements HasConstantsInterface, HasExtendsInterface, HasMethodsInterface
{
    use HasConstants;
    use HasExtends;
    use HasMethods;

    protected function renderHeader(EntityAliases $entityAliases): string
    {
        $result = [];

        $result[] = 'interface';
        $result[] = $this->getBaseClassName();

        if ($this->extends !== null) {
            $result[] = 'extends';
            $result[] = $this->extends;
        }

        return implode(' ', $result);
    }

    protected function renderBody(EntityAliases $entityAliases): string
    {
        $constants = $this->renderConstants($entityAliases);
        $methods = $this->renderMethods($entityAliases, true);

        return implode(PHP_EOL . PHP_EOL, array_filter([$constants, $methods]));
    }
}
