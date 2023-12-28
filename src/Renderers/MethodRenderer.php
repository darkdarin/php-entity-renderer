<?php

namespace DarkDarin\PhpEntityRenderer\Renderers;

use DarkDarin\PhpEntityRenderer\Contracts\EntityRendererInterface;
use DarkDarin\PhpEntityRenderer\Contracts\TypeRendererInterface;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Helpers\HasAttributes;
use DarkDarin\PhpEntityRenderer\Helpers\HasDocBlock;
use DarkDarin\PhpEntityRenderer\Helpers\HasModifierInheritance;
use DarkDarin\PhpEntityRenderer\Helpers\HasModifierStatic;
use DarkDarin\PhpEntityRenderer\Helpers\HasModifierVisibility;
use DarkDarin\PhpEntityRenderer\Helpers\IndentsHelper;
use DarkDarin\PhpEntityRenderer\Renderers\Types\BuiltinTypeRenderer;

class MethodRenderer implements EntityRendererInterface
{
    use HasAttributes;
    use HasDocBlock;
    use HasModifierInheritance;
    use HasModifierStatic;
    use HasModifierVisibility;

    /** @var list<ParameterRenderer> */
    private array $parameters = [];
    private TypeRendererInterface $returnType = BuiltinTypeRenderer::Mixed;
    private ?string $methodBody = null;

    public function __construct(
        public string $name,
    ) {
        $this->docBlock = new DocBlockRenderer();
    }

    public function addParameter(ParameterRenderer $parameterRenderer): self
    {
        if ($parameterRenderer->getDefault() !== null) {
            $this->parameters[] = $parameterRenderer;
            return $this;
        }

        $requiredParameters = [];
        $defaultParameters = [];
        foreach ($this->parameters as $parameter) {
            if ($parameter->getDefault() !== null) {
                $defaultParameters[] = $parameter;
            } else {
                $requiredParameters[] = $parameter;
            }
        }

        $this->parameters = array_merge($requiredParameters, [$parameterRenderer], $defaultParameters);

        return $this;
    }

    public function setReturnType(TypeRendererInterface $type): self
    {
        $this->returnType = $type;

        return $this;
    }

    public function setMethodBody(string $methodBody): self
    {
        $this->methodBody = $methodBody;

        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->addComment($description);
        $this->addComment();

        return $this;
    }

    public function render(EntityAliases $entityAliases, bool $withoutBody = false): string
    {
        $docBlock = $this->renderDocBlock($entityAliases);
        $method = $this->renderMethod($entityAliases, $this->renderBody(), $withoutBody);

        return $docBlock . $method;
    }

    protected function renderDocBlock(EntityAliases $entityAliases): string
    {
        if (empty($this->parameters)) {
            return $this->docBlock->render($entityAliases);
        }

        foreach ($this->parameters as $parameter) {
            $line = '@param ' . $parameter->renderDocBlock($entityAliases);
            $this->docBlock->addLine($line);
        }

        $this->docBlock->addLine('@return ' . $this->returnType->renderDocBlock($entityAliases));

        return $this->docBlock->render($entityAliases);
    }

    protected function renderMethod(EntityAliases $entityAliases, string $methodBody, bool $withoutBody): string
    {
        $result = [];
        $modifiers = $this->renderModifiers();
        if (!empty($modifiers)) {
            $result[] = $modifiers;
        }

        $result[] = 'function';
        $result[] = $this->name;

        $signature = $this->renderSignatureInline($entityAliases, $methodBody, $withoutBody);
        $method = $withoutBody ? ';' : PHP_EOL . '{' . $methodBody . '}';

        if (strlen($signature) > 80) {
            $signature = $this->renderSignatureColumn($entityAliases, $methodBody, $withoutBody);
            $method = $withoutBody ? ';' : ' {' . $methodBody . '}';
        }

        return implode(' ', $result) . $signature . $method;
    }

    protected function renderSignatureInline(EntityAliases $entityAliases,): string
    {
        $parameters = [];
        foreach ($this->parameters as $parameter) {
            $parameters[] = $parameter->render($entityAliases, true);
        }

        $signature = implode(', ', $parameters);
        $returnType = $this->returnType->render($entityAliases);
        return '(' . $signature . '): ' . $returnType;
    }

    protected function renderSignatureColumn(EntityAliases $entityAliases): string
    {
        $parameters = [];
        foreach ($this->parameters as $parameter) {
            $parameters[] = $parameter->render($entityAliases);
        }

        $signature = IndentsHelper::indent(implode(',' . PHP_EOL, $parameters));
        $returnType = $this->returnType->render($entityAliases);
        return '(' . PHP_EOL . $signature . PHP_EOL . '): ' . $returnType;
    }

    protected function renderBody(): string
    {
        if ($this->methodBody === null) {
            return '';
        }

        return PHP_EOL . IndentsHelper::indent($this->methodBody) . PHP_EOL;
    }
}
