<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

trait HasModifierStatic
{
    use HasModifiers;

    private bool $isStatic = false;

    public function isStatic(): bool
    {
        return $this->isStatic;
    }

    public function setStatic(bool $isStatic = true): self
    {
        $this->isStatic = $isStatic;

        return $this;
    }
}
