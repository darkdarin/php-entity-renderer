<?php

namespace DarkDarin\PhpEntityRenderer\Renderers\Types;

use DarkDarin\PhpEntityRenderer\Contracts\TypeRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;

enum BuiltinTypeRenderer: string implements TypeRendererInterface
{
    case Callable = 'callable';
    case Bool = 'bool';
    case Float = 'float';
    case Int = 'int';
    case String = 'string';
    case Iterable = 'iterable';
    case Object = 'object';
    case Mixed = 'mixed';
    case Null = 'null';
    case True = 'true';
    case False = 'false';
    case Void = 'void';
    case Never = 'never';

    public function renderDocBlock(EntityAliases $entityAliases): string
    {
        return $this->render($entityAliases);
    }

    public function render(EntityAliases $entityAliases): string
    {
        return $this->value;
    }
}
