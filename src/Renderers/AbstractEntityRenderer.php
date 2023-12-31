<?php

namespace DarkDarin\PhpEntityRenderer\Renderers;

use DarkDarin\PhpEntityRenderer\Contracts\EntityRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Helpers\ClassNameHelper;
use DarkDarin\PhpEntityRenderer\Helpers\HasAttributes;
use DarkDarin\PhpEntityRenderer\Helpers\HasDocBlock;
use DarkDarin\PhpEntityRenderer\Helpers\HasNamespaces;
use DarkDarin\PhpEntityRenderer\Helpers\IndentsHelper;

abstract class AbstractEntityRenderer implements EntityRendererInterface
{
    use HasAttributes;
    use HasDocBlock;
    use HasNamespaces;

    public function __construct(
        private readonly string $className,
    ) {
        $this->docBlock = new DocBlockRenderer();
    }

    public function setDescription(string $description): self
    {
        $this->addComment($description);
        $this->addComment();

        return $this;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getBaseClassName(): string
    {
        return ClassNameHelper::getBaseName($this->className);
    }

    public function getNamespace(): string
    {
        return ClassNameHelper::getNamespace($this->className);
    }

    public function render(EntityAliases $entityAliases): string
    {
        $namespace = $this->getNamespace();
        if (!empty($namespace)) {
            $namespace = 'namespace ' . $namespace . ';' . PHP_EOL . PHP_EOL;
        }

        $uses = $this->renderUses($entityAliases, $this->className);
        if (method_exists($this, 'renderDynamicProperties')) {
            $this->renderDynamicProperties($entityAliases, $this->docBlock);
        }
        $docBlock = $this->docBlock->render($entityAliases);
        $attributes = $this->renderAttributes($entityAliases);
        $header = $this->renderHeader($entityAliases);
        $body = IndentsHelper::indent($this->renderBody($entityAliases));

        return <<<PHP
<?php

$namespace$uses$docBlock$attributes$header
{
$body
}
PHP;
    }

    abstract protected function renderHeader(EntityAliases $entityAliases): string;

    abstract protected function renderBody(EntityAliases $entityAliases): string;
}
