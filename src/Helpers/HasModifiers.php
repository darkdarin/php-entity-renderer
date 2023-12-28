<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

trait HasModifiers
{
    protected function renderModifiers(): string
    {
        $modifiers = [];

        if (method_exists($this, 'getInheritanceModifier')) {
            $inheritance = $this->getInheritanceModifier();
            if ($inheritance !== null) {
                $modifiers[] = $inheritance->value;
            }
        }

        if (method_exists($this, 'getVisibilityModifier')) {
            $visibility = $this->getVisibilityModifier();
            if ($visibility !== null) {
                $modifiers[] = $visibility->value;
            }
        }

        if (method_exists($this, 'isStatic')) {
            if ($this->isStatic()) {
                $modifiers[] = 'static';
            }
        }

        if (method_exists($this, 'isReadonly')) {
            if ($this->isReadonly()) {
                $modifiers[] = 'readonly';
            }
        }

        return implode(' ', $modifiers);
    }
}
