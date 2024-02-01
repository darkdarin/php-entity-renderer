<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

use DarkDarin\PhpEntityRenderer\Enums\VisibilityModifierEnum;

/**
 * @psalm-api
 */
interface HasModifierVisibilityInterface
{
    public function getVisibilityModifier(): ?VisibilityModifierEnum;

    public function setVisibilityModifier(?VisibilityModifierEnum $visibilityModifier = null): self;
}
