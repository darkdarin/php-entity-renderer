<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

class ClassNameHelper
{
    public static function getNamespace(string $className): string
    {
        $classNameArray = explode('\\', ltrim($className, '\\'));
        array_pop($classNameArray);

        return implode('\\', $classNameArray);
    }

    public static function getBaseName(string $className): string
    {
        return basename(str_replace('\\', '/', $className));
    }
}
