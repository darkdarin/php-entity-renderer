<?php

namespace DarkDarin\PhpEntityRenderer\Renderers;

use DarkDarin\PhpEntityRenderer\Contracts\EntityRendererInterface;
use DarkDarin\PhpEntityRenderer\Contracts\EntityWithDescriptionInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Helpers\HasDocBlock;

class EnumCaseRenderer implements EntityRendererInterface, EntityWithDescriptionInterface
{
    use HasDocBlock;

    public function __construct(
        private readonly string $name,
        private readonly ValueRenderer $value,
    ) {
        $this->docBlock = new DocBlockRenderer();
    }

    public function setDescription(string $description): self
    {
        $this->addComment($description);
        $this->addComment();

        return $this;
    }

    public function render(EntityAliases $entityAliases): string
    {
        $docBlock = $this->docBlock->render($entityAliases);
        return $docBlock . 'case ' . $this->name . ' = ' . $this->value->render($entityAliases) . ';';
    }
}
