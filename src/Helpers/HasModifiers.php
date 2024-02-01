<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

use DarkDarin\PhpEntityRenderer\Contracts\HasModifierInheritanceInterface;
use DarkDarin\PhpEntityRenderer\Contracts\HasModifierReadonlyInterface;
use DarkDarin\PhpEntityRenderer\Contracts\HasModifierStaticInterface;
use DarkDarin\PhpEntityRenderer\Contracts\HasModifierVisibilityInterface;

trait HasModifiers
{
    protected function renderModifiers(): string
    {
        $modifiers = [];

        if ($this instanceof HasModifierInheritanceInterface) {
            $inheritance = $this->getInheritanceModifier();
            if ($inheritance !== null) {
                $modifiers[] = $inheritance->value;
            }
        }

        if ($this instanceof HasModifierVisibilityInterface) {
            $visibility = $this->getVisibilityModifier();
            if ($visibility !== null) {
                $modifiers[] = $visibility->value;
            }
        }

        if ($this instanceof HasModifierStaticInterface) {
            if ($this->isStatic()) {
                $modifiers[] = 'static';
            }
        }

        if ($this instanceof HasModifierReadonlyInterface) {
            if ($this->isReadonly()) {
                $modifiers[] = 'readonly';
            }
        }

        return implode(' ', $modifiers);
    }
}
