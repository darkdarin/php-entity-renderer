<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Renderers\MethodRenderer;

trait HasMethods
{
    /** @var list<MethodRenderer> */
    private array $methods = [];

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function addMethod(MethodRenderer $method): self
    {
        $this->methods[] = $method;

        return $this;
    }

    protected function renderMethods(EntityAliases $entityAliases, bool $withoutBody = false): string
    {
        $methods = array_map(
            fn (MethodRenderer $method) => $method->render($entityAliases, $withoutBody),
            $this->methods
        );

        return implode(PHP_EOL . PHP_EOL, $methods);
    }
}
