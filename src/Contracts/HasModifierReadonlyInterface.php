<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

/**
 * @psalm-api
 */
interface HasModifierReadonlyInterface
{
    public function isReadonly(): bool;

    public function setReadonly(bool $isReadonly = true): self;
}
