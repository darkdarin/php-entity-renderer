<?php

namespace DarkDarin\PhpEntityRenderer\Renderers;

use DarkDarin\PhpEntityRenderer\Contracts\HasConstantsInterface;
use DarkDarin\PhpEntityRenderer\Contracts\HasImplementsInterface;
use DarkDarin\PhpEntityRenderer\Contracts\HasMethodsInterface;
use DarkDarin\PhpEntityRenderer\Contracts\HasTraitsInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Enums\EnumTypeEnum;
use DarkDarin\PhpEntityRenderer\Helpers\HasConstants;
use DarkDarin\PhpEntityRenderer\Helpers\HasImplements;
use DarkDarin\PhpEntityRenderer\Helpers\HasMethods;
use DarkDarin\PhpEntityRenderer\Helpers\HasTraits;

/**
 * @psalm-api
 */
class EnumRenderer extends AbstractEntityRenderer implements
    HasConstantsInterface,
    HasImplementsInterface,
    HasMethodsInterface,
    HasTraitsInterface
{
    use HasConstants;
    use HasImplements;
    use HasMethods;
    use HasTraits;

    /** @var list<EnumCaseRenderer> */
    private array $cases = [];
    private ?EnumTypeEnum $type = null;

    public function getCases(): array
    {
        return $this->cases;
    }

    public function addCase(EnumCaseRenderer $case): self
    {
        $this->cases[] = $case;

        return $this;
    }

    public function getType(): ?EnumTypeEnum
    {
        return $this->type;
    }

    public function setType(?EnumTypeEnum $type = null): self
    {
        $this->type = $type;

        return $this;
    }

    protected function renderHeader(EntityAliases $entityAliases): string
    {
        $result = [];

        $result[] = 'enum';

        if ($this->type !== null) {
            $result[] = $this->getBaseClassName() . ': ' . $this->type->value;
        } else {
            $result[] = $this->getBaseClassName();
        }

        if (!empty($this->implements)) {
            $result[] = 'implements';
            $result[] = implode(', ', $this->implements);
        }

        return implode(' ', $result);
    }

    protected function renderBody(EntityAliases $entityAliases): string
    {
        $traits = $this->renderTraits();
        $constants = $this->renderConstants($entityAliases);
        $cases = $this->renderCases($entityAliases);
        $methods = $this->renderMethods($entityAliases);

        return implode(PHP_EOL . PHP_EOL, array_filter([$traits, $constants, $cases, $methods]));
    }

    protected function renderCases(EntityAliases $entityAliases): string
    {
        $cases = array_map(
            fn(EnumCaseRenderer $case) => $case->render($entityAliases),
            $this->cases
        );

        return implode(PHP_EOL, $cases);
    }
}
