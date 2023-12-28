<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

use DarkDarin\PhpEntityRenderer\EntityAliases;

trait HasNamespaces
{
    protected function renderUses(EntityAliases $entityAliases, string $currentClassName): string
    {
        $aliases = $entityAliases->getAliases();

        asort($aliases);

        $uses = [];
        foreach ($aliases as $alias => $className) {
            $classBaseName = ClassNameHelper::getBaseName($className);

            if ($classBaseName !== $alias) {
                $uses[] = sprintf('use %s as %s;', ltrim($className, '\\'), $alias);
            } else {
                if (ClassNameHelper::getNamespace($className) !== ClassNameHelper::getNamespace($currentClassName)) {
                    $uses[] = sprintf('use %s;', $className);
                }
            }
        }

        if (empty($uses)) {
            return '';
        }

        return implode(PHP_EOL, $uses) . PHP_EOL . PHP_EOL;
    }
}
