<?php

namespace DarkDarin\PhpEntityRenderer\Contracts;

use DarkDarin\PhpEntityRenderer\Renderers\DocBlockRenderer;

/**
 * @psalm-api
 */
interface HasDocBlockInterface
{
    public function getDocBlock(): DocBlockRenderer;

    public function addComment(string $comment = ''): self;

    public function setDocBlock(DocBlockRenderer $docBlock): self;
}
