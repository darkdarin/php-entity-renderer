<?php

namespace DarkDarin\PhpEntityRenderer\Renderers\Types;

use DarkDarin\PhpEntityRenderer\Contracts\TypeRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;

/**
 * @psalm-api
 */
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

    public function setNullable(bool $nullable = true): TypeRendererInterface
    {
        if (!$nullable) {
            return $this;
        }

        return match ($this) {
            self::Never, self::Void, self::Null, self::Mixed => $this,
            default => new NullableTypeRenderer($this),
        };
    }

    public function isNullable(): bool
    {
        return $this === self::Null || $this === self::Mixed;
    }
}
