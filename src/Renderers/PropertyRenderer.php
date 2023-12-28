<?php

namespace DarkDarin\PhpEntityRenderer\Renderers;

use DarkDarin\PhpEntityRenderer\Contracts\DocBlockRendererInterface;
use DarkDarin\PhpEntityRenderer\Contracts\EntityRendererInterface;
use DarkDarin\PhpEntityRenderer\Contracts\TypeRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Enums\VisibilityModifierEnum;
use DarkDarin\PhpEntityRenderer\Helpers\HasAttributes;
use DarkDarin\PhpEntityRenderer\Helpers\HasDocBlock;
use DarkDarin\PhpEntityRenderer\Helpers\HasModifierReadonly;
use DarkDarin\PhpEntityRenderer\Helpers\HasModifierVisibility;
use DarkDarin\PhpEntityRenderer\Renderers\Types\ArrayTypeRenderer;

class PropertyRenderer implements EntityRendererInterface, DocBlockRendererInterface
{
    use HasAttributes;
    use HasDocBlock;
    use HasModifierReadonly;
    use HasModifierVisibility;

    private ?string $description = null;
    private ?string $default = null;

    public function __construct(
        private readonly string $name,
        private readonly TypeRendererInterface $type,
    ) {
        $this->docBlock = new DocBlockRenderer();
        $this->visibilityModifier = VisibilityModifierEnum::Public;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): TypeRendererInterface
    {
        return $this->type;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDefault(string $default): void
    {
        $this->default = $default;
    }

    public function getDefault(): ?string
    {
        return $this->default;
    }

    public function renderDocBlock(EntityAliases $entityAliases): string
    {
        $result = $this->type->renderDocBlock($entityAliases) . ' $' . $this->name;
        if ($this->description !== null) {
            $result .= ' ' . $this->description;
        }

        return $result;
    }

    public function render(EntityAliases $entityAliases): string
    {
        if ($this->type instanceof ArrayTypeRenderer || $this->description !== null) {
            $this->docBlock->addLine('@var ' . $this->renderDocBlock($entityAliases));
        }
        $docBlock = $this->docBlock->render($entityAliases);

        $result = [];
        $modifiers = $this->renderModifiers();
        if (!empty($modifiers)) {
            $result[] = $modifiers;
        }

        $result[] = $this->type->render($entityAliases);
        $result[] = '$' . $this->name;

        return $docBlock . implode(' ', $result) . ';';
    }
}
