<?php

namespace DarkDarin\PhpEntityRenderer\Renderers;

use DarkDarin\PhpEntityRenderer\Contracts\DocBlockRendererInterface;
use DarkDarin\PhpEntityRenderer\Contracts\EntityRendererInterface;
use DarkDarin\PhpEntityRenderer\Contracts\EntityWithDescriptionInterface;
use DarkDarin\PhpEntityRenderer\Contracts\HasAttributesInterface;
use DarkDarin\PhpEntityRenderer\Contracts\HasDocBlockInterface;
use DarkDarin\PhpEntityRenderer\Contracts\HasModifierReadonlyInterface;
use DarkDarin\PhpEntityRenderer\Contracts\HasModifierVisibilityInterface;
use DarkDarin\PhpEntityRenderer\Contracts\TypeRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Enums\VisibilityModifierEnum;
use DarkDarin\PhpEntityRenderer\Helpers\HasAttributes;
use DarkDarin\PhpEntityRenderer\Helpers\HasDocBlock;
use DarkDarin\PhpEntityRenderer\Helpers\HasModifierReadonly;
use DarkDarin\PhpEntityRenderer\Helpers\HasModifierVisibility;
use DarkDarin\PhpEntityRenderer\Renderers\Types\ArrayTypeRenderer;

/**
 * @psalm-api
 */
class PropertyRenderer implements
    EntityRendererInterface,
    DocBlockRendererInterface,
    EntityWithDescriptionInterface,
    HasAttributesInterface,
    HasDocBlockInterface,
    HasModifierReadonlyInterface,
    HasModifierVisibilityInterface
{
    use HasAttributes;
    use HasDocBlock;
    use HasModifierReadonly;
    use HasModifierVisibility;

    private ?string $description = null;
    private ?ValueRenderer $default = null;

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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDefault(ValueRenderer $default): void
    {
        $this->default = $default;
    }

    public function getDefault(): ?ValueRenderer
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

        if ($this->default !== null) {
            $result [] = '=';
            $result [] = $this->default->render($entityAliases);
        }

        return $docBlock . implode(' ', $result) . ';';
    }
}
