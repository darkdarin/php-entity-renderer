<?php

namespace DarkDarin\PhpEntityRenderer\Renderers;

use DarkDarin\PhpEntityRenderer\Contracts\EntityRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Helpers\HasDocBlock;
use DarkDarin\PhpEntityRenderer\Helpers\HasModifierVisibility;

class ConstantRenderer implements EntityRendererInterface
{
    use HasDocBlock;
    use HasModifierVisibility;

    public function __construct(
        private readonly string $name,
        private readonly string $value,
    ) {
        $this->docBlock = new DocBlockRenderer();
    }

    public function render(EntityAliases $entityAliases): string
    {
        $modifiers = $this->renderModifiers();
        if (!empty($modifiers)) {
            $modifiers .= ' ';
        }

        $result = $modifiers . 'const ' . $this->name . ' = ' . $this->value . ';';
        $docBlock = $this->docBlock->render($entityAliases);

        return $docBlock . $result;
    }
}
