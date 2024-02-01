<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

/**
 * @psalm-api
 */
interface EntityWithDescriptionInterface
{
    public function setDescription(string $description): self;
}
