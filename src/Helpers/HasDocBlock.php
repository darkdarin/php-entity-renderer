<?php

namespace DarkDarin\PhpEntityRenderer\Helpers;

use DarkDarin\PhpEntityRenderer\Renderers\DocBlockRenderer;

trait HasDocBlock
{
    private DocBlockRenderer $docBlock;

    public function getDocBlock(): DocBlockRenderer
    {
        return $this->docBlock;
    }

    public function addComment(string $comment = ''): self
    {
        $this->docBlock->addLine($comment);

        return $this;
    }

    public function setDocBlock(DocBlockRenderer $docBlock): self
    {
        $this->docBlock = $docBlock;

        return $this;
    }
}
