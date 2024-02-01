<?php

namespace DarkDarin\PhpEntityRenderer\Renderers;

use DarkDarin\PhpEntityRenderer\Contracts\DocBlockRendererInterface;
use DarkDarin\PhpEntityRenderer\Contracts\EntityRendererInterface;
use DarkDarin\PhpEntityRenderer\Contracts\EntityWithDescriptionInterface;
use DarkDarin\PhpEntityRenderer\Contracts\TypeRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Helpers\HasAttributes;
use DarkDarin\PhpEntityRenderer\Helpers\HasModifierReadonly;
use DarkDarin\PhpEntityRenderer\Helpers\HasModifierVisibility;

class ParameterRenderer implements EntityRendererInterface, DocBlockRendererInterface, EntityWithDescriptionInterface
{
    use HasAttributes;
    use HasModifierReadonly;
    use HasModifierVisibility;

    private ?string $description = null;
    private ?ValueRenderer $default = null;

    public function __construct(
        private readonly string $name,
        private readonly TypeRendererInterface $type,
    ) {}

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

    public function render(EntityAliases $entityAliases, bool $inline = false): string
    {
        $attributes = $this->renderAttributes($entityAliases, $inline);

        $modifiers = $this->renderModifiers();
        if (!empty($modifiers)) {
            $result[] = $modifiers;
        }

        $result[] = $this->type->render($entityAliases);
        $result[] = '$' . $this->name;

        if ($this->default !== null) {
            $result[] = '=';
            $result[] = $this->default->render($entityAliases);
        }

        $result = implode(' ', $result);

        if (!empty($attributes)) {
            return $inline ? $attributes . ' ' . $result : $attributes . PHP_EOL . $result;
        }

        return $result;
    }
}
