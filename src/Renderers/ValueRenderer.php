<?php

namespace DarkDarin\PhpEntityRenderer\Renderers;

use DarkDarin\PhpEntityRenderer\Contracts\EntityRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;

class ValueRenderer implements EntityRendererInterface
{
    public function __construct(
        private readonly mixed $value,
    ) {}

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function render(EntityAliases $entityAliases): string
    {
        $export = var_export($this->value, true);

        $patterns = [
            "/array \(/" => '[',
            "/^([ ]*)\)(,?)$/m" => '$1]$2',
            "/=>[ ]?\n[ ]+\[/" => '=> [',
            "/([ ]*)(\'[^\']+\') => ([\[\'])/" => '$1$2 => $3',
            "/NULL/" => "null",
            "/FALSE/" => "false",
            "/TRUE/" => "true",
            "/\[\n\]/" => "[]"
        ];

        return preg_replace(array_keys($patterns), array_values($patterns), $export);
    }
}
