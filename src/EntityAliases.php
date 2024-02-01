<?php

namespace DarkDarin\PhpEntityRenderer;

use DarkDarin\PhpEntityRenderer\Helpers\ClassNameHelper;

class EntityAliases
{
    /** @var array<string, class-string> */
    private array $aliases = [];

    /**
     * @param class-string $type
     * @return string
     */
    public function addAlias(string $type): string
    {
        if ($this->isBuiltin($type)) {
            return $type;
        }

        foreach ($this->aliases as $alias => $class) {
            if ($class === $type) {
                return $alias;
            }
        }

        $typeAlias = $this->generateAlias(ClassNameHelper::getBaseName($type));
        $this->aliases[$typeAlias] = $type;

        return $typeAlias;
    }

    /**
     * @return array<string, class-string>
     */
    public function getAliases(): array
    {
        return $this->aliases;
    }

    private function generateAlias(string $classAlias, int $index = null): string
    {
        if ($index !== null) {
            $classAliasName = $classAlias . $index;
        } else {
            $index = 0;
            $classAliasName = $classAlias;
        }

        if (array_key_exists($classAliasName, $this->aliases)) {
            return $this->generateAlias($classAlias, ++$index);
        }

        return $classAlias;
    }

    private function isBuiltin(string $type): bool
    {
        return in_array(strtolower($type), [
            'array',
            'callable',
            'bool',
            'float',
            'int',
            'string',
            'iterable',
            'object',
            'mixed'
        ]);
    }
}
