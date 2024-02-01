<?php

namespace DarkDarin\PhpEntityRenderer\Renderers;

use DarkDarin\PhpEntityRenderer\Contracts\EntityRendererInterface;
use DarkDarin\PhpEntityRenderer\Contracts\HasDocBlockInterface;
use DarkDarin\PhpEntityRenderer\Contracts\HasModifierVisibilityInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Helpers\HasDocBlock;
use DarkDarin\PhpEntityRenderer\Helpers\HasModifierVisibility;

/**
 * @psalm-api
 */
class ConstantRenderer implements EntityRendererInterface, HasDocBlockInterface, HasModifierVisibilityInterface
{
    use HasDocBlock;
    use HasModifierVisibility;

    public function __construct(
        private readonly string $name,
        private readonly ValueRenderer $value,
    ) {
        $this->docBlock = new DocBlockRenderer();
    }

    public function render(EntityAliases $entityAliases): string
    {
        $modifiers = $this->renderModifiers();
        if (!empty($modifiers)) {
            $modifiers .= ' ';
        }

        $result = $modifiers . 'const ' . $this->name . ' = ' . $this->value->render($entityAliases) . ';';
        $docBlock = $this->docBlock->render($entityAliases);

        return $docBlock . $result;
    }
}
