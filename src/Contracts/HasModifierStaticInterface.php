<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

/**
 * @psalm-api
 */
interface HasModifierStaticInterface
{
    public function isStatic(): bool;

    public function setStatic(bool $isStatic = true): self;
}
