<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

use DarkDarin\PhpEntityRenderer\Enums\VisibilityModifierEnum;

trait HasModifierVisibility
{
    use HasModifiers;

    private ?VisibilityModifierEnum $visibilityModifier = null;

    public function getVisibilityModifier(): ?VisibilityModifierEnum
    {
        return $this->visibilityModifier;
    }

    public function setVisibilityModifier(?VisibilityModifierEnum $visibilityModifier = null): self
    {
        $this->visibilityModifier = $visibilityModifier;

        return $this;
    }
}
