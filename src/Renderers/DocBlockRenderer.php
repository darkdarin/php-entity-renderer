<?php

namespace DarkDarin\PhpEntityRenderer\Renderers;

use DarkDarin\PhpEntityRenderer\Contracts\EntityRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Helpers\IndentsHelper;

/**
 * @psalm-api
 */
class DocBlockRenderer implements EntityRendererInterface
{
    /** @var list<string> */
    private array $lines = [];

    public function addLine(string $line = ''): void
    {
        $this->lines = array_merge($this->lines, explode(PHP_EOL, $line));
    }

    public function getLines(): array
    {
        return $this->lines;
    }

    public function render(EntityAliases $entityAliases): string
    {
        if (empty($this->lines)) {
            return '';
        }

        $renderedLines = [];
        $lines = $this->lines;

        for ($i = count($this->lines) - 1; $i >= 0; $i--) {
            if (empty($this->lines[$i])) {
                array_pop($lines);
            } else {
                break;
            }
        }

        foreach ($lines as $line) {
            $renderedLines[] = IndentsHelper::preLine($line, ' * ');
        }

        return '/**' . PHP_EOL . implode(PHP_EOL, $renderedLines) . PHP_EOL . ' */' . PHP_EOL;
    }
}
