<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Renderers\ConstantRenderer;

trait HasConstants
{
    /** @var list<ConstantRenderer> */
    private array $constants = [];

    public function getConstants(): array
    {
        return $this->constants;
    }

    public function addConstant(ConstantRenderer $constant): self
    {
        $this->constants[] = $constant;

        return $this;
    }

    private function renderConstants(EntityAliases $entityAliases): string
    {
        $constants = array_map(
            fn(ConstantRenderer $constant) => $constant->render($entityAliases),
            $this->constants
        );

        return implode(PHP_EOL, $constants);
    }
}
