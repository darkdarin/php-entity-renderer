<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

interface EntityWithDescriptionInterface
{
    public function setDescription(string $description): self;
}
