<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

interface TypeRendererInterface extends EntityRendererInterface, DocBlockRendererInterface
{
    public function setNullable(bool $nullable = true): TypeRendererInterface;

    public function isNullable(): bool;
}
