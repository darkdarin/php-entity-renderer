<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

class IndentsHelper
{
    public static function indent(string $content): string
    {
        return self::indents($content, 1);
    }

    public static function indents(string $content, int $indents = 0): string
    {
        return self::preLine($content, str_repeat('    ', $indents));
    }

    public static function preLine(string $content, string $fill): string
    {
        $lines = explode(PHP_EOL, $content);

        return implode(PHP_EOL, array_map(fn(string $line) => empty(trim($fill . $line)) ? '' : $fill . $line, $lines));
    }
}
