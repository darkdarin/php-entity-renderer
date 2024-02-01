<?php

namespace DarkDarin\PhpEntityRenderer\Renderers;

use DarkDarin\PhpEntityRenderer\Contracts\EntityRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Helpers\IndentsHelper;

class AttributeRenderer implements EntityRendererInterface
{
    /**
     * @param list<ValueRenderer>|array<string, ValueRenderer> $arguments
     */
    public function __construct(
        private readonly string $className,
        private readonly array $arguments = [],
    ) {}

    public function getName(): string
    {
        return $this->className;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function render(EntityAliases $entityAliases): string
    {
        $alias = $entityAliases->addAlias($this->className);
        $arguments = $this->renderArguments($entityAliases);

        return sprintf('#[%s%s]', $alias, $arguments);
    }

    protected function renderArguments(EntityAliases $entityAliases): string
    {
        if (empty($this->arguments)) {
            return '';
        }

        $argumentList = [];
        foreach ($this->arguments as $name => $value) {
            $argumentList[] = is_string($name) ? $name . ': ' . $value->render($entityAliases) : $value->render(
                $entityAliases
            );
        }
        $arguments = '(' . implode(', ', $argumentList) . ')';
        if (strlen($arguments) > 80) {
            $arguments = '(' . PHP_EOL . IndentsHelper::indent(implode(PHP_EOL, $argumentList)) . PHP_EOL . ')';
        }

        return $arguments;
    }
}
