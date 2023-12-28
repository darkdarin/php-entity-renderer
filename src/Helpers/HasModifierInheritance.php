<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

use DarkDarin\PhpEntityRenderer\Enums\InheritanceModifierEnum;

trait HasModifierInheritance
{
    use HasModifiers;

    private ?InheritanceModifierEnum $inheritanceModifier = null;

    public function getInheritanceModifier(): ?InheritanceModifierEnum
    {
        return $this->inheritanceModifier;
    }

    public function setInheritanceModifier(InheritanceModifierEnum $inheritanceModifier): self
    {
        $this->inheritanceModifier = $inheritanceModifier;

        return $this;
    }


}
