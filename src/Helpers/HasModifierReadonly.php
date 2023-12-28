<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

trait HasModifierReadonly
{
    use HasModifiers;

    private bool $isReadonly = false;

    public function isReadonly(): bool
    {
        return $this->isReadonly;
    }

    public function setReadonly(bool $isReadonly = true): self
    {
        $this->isReadonly = $isReadonly;

        return $this;
    }
}
