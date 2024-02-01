<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

use DarkDarin\PhpEntityRenderer\Enums\InheritanceModifierEnum;

/**
 * @psalm-api
 */
interface HasModifierInheritanceInterface
{
    public function getInheritanceModifier(): ?InheritanceModifierEnum;

    public function setInheritanceModifier(InheritanceModifierEnum $inheritanceModifier): self;
}
