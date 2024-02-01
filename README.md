# php-entity-renderer
Renderer helpers to make PHP code for classes, interfaces, traits and enums 

# Install

```bash
composer require darkdarin/php-entity-renderer
```

# Usage
Each renderer has method `render`, which generates a text representation of the entity.

This method need one parameter - `DarkDarin\PhpEntityRenderer\EntityAliases`. 
This object stores of collection of all usage aliases (of classes, enums, interfaces, traits)
that are used within the current entity scope.

Also, same renderers have `renderDocBlock` method, which generate a text representation of the
entity for DocBlock.

Renderers with `renderDocBlock` method:
* All type renderers (`ArrayTypeRenderer`, `BuiltinTypeRenderer`, `ClassTypeRenderer`, 
`IntersectTypeRenderer`, `NullableTypeRenderer`, `UnionTypeRenderer`)
* `ParameterRenderer`
* `PropertyRenderer`

## Type Renderers
Renderers for generate correct types.
All types have methods:
```php
// Return new type renderer with nullable type
$nullableTypeRenderer = $typeRenderer->setNullable();
// Check current type is nullable
$typeRenderer->isNullable();
```

### BuiltinTypeRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\Types\BuiltinTypeRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;

$renderer = BuiltinTypeRenderer::Float;
echo $renderer->render(new EntityAliases());
echo $renderer->renderDocBlock(new EntityAliases());
```
```
float
float
```
### ClassTypeRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\Types\ClassTypeRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;

$renderer = new ClassTypeRenderer('\\App\\MyClass');
echo $renderer->render(new EntityAliases());
echo $renderer->renderDocBlock(new EntityAliases());
```
```
MyClass
MyClass
```
### ArrayTypeRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\Types\ArrayTypeRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\Types\BuiltinTypeRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;

$renderer = new ArrayTypeRenderer(BuiltinTypeRenderer::String);
echo $renderer->render(new EntityAliases());
echo $renderer->renderDocBlock(new EntityAliases());
```
```
array
list<string>
```
### NullableTypeRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\Types\NullableTypeRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\Types\BuiltinTypeRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;

$renderer = new NullableTypeRenderer(BuiltinTypeRenderer::String);
echo $renderer->render(new EntityAliases());
echo $renderer->renderDocBlock(new EntityAliases());
```
```
?string
string|null
```
### IntersectTypeRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\Types\IntersectTypeRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\Types\ClassTypeRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;

$renderer = new IntersectTypeRenderer(
    new ClassTypeRenderer('\\App\\MyInterfaceOne'), 
    new ClassTypeRenderer('\\App\\MyInterfaceTwo')
 );
echo $renderer->render(new EntityAliases());
echo $renderer->renderDocBlock(new EntityAliases());
```
```
MyInterfaceOne&MyInterfaceTwo
MyInterfaceOne&MyInterfaceTwo
```
### UnionTypeRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\Types\UnionTypeRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\Types\ClassTypeRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\Types\BuiltinTypeRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;

$renderer = new UnionTypeRenderer(
    new ClassTypeRenderer('\\App\\MyClass'), 
    BuiltinTypeRenderer::Int
 );
echo $renderer->render(new EntityAliases());
echo $renderer->renderDocBlock(new EntityAliases());
```
```
MyClass|int
MyClass|int
```

## Entity Renderers
Renderers for generate entities

Same entity renderers have special methods for set different modifiers.

#### Inheritance Modifier
```php
public function setInheritanceModifier(InheritanceModifierEnum $inheritanceModifier): self
public function getInheritanceModifier(): ?InheritanceModifierEnum
InheritanceModifierEnum::Abstract
InheritanceModifierEnum::Final
```
Can be used in:
* `ClassRenderer`
* `MethodRenderer`

#### Readonly Modifier
```php
public function setReadonly(bool $isReadonly = true): self
public function isReadonly(): bool
```
Can be used in:
* `ClassRenderer`
* `ParameterRenderer`
* `PropertyRenderer`

#### Visibility Modifier
```php
public function setVisibilityModifier(?VisibilityModifierEnum $visibilityModifier = null): self
public function getVisibilityModifier(): ?VisibilityModifierEnum
VisibilityModifierEnum::Public
VisibilityModifierEnum::Protected
VisibilityModifierEnum::Private
```
Can be used in:
* `MethodRenderer`
* `ParameterRenderer`
* `PropertyRenderer`
* `ConstantRenderer`

#### Static Modifiers
```php
public function setStatic(bool $isStatic = true): self
public function isStatic(): bool
```
Can be used in:
* `MethodRenderer`

### ValueRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\ValueRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;

$myValue = [
  'some' => 'foo',
  'different' => 'bar',
];
$renderer = new ValueRenderer($myValue);
echo $renderer->render(new EntityAliases());
```
```php
[
  'some' => 'foo',
  'different' => 'bar',
]
```

### ConstantRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\ConstantRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\ValueRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;

$renderer = new ConstantRenderer('MY_CONST', new ValueRenderer(2345));
echo $renderer->render(new EntityAliases());
```
```php
const MY_CONST = 2345;
```

### DocBlockRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\DocBlockRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;

$renderer = new DocBlockRenderer();
$renderer->addLine('My comment');
$renderer->addLine('@param int $foo My param');
echo $renderer->render(new EntityAliases());
```
```php
/**
 * My comment
 * @param int $foo My param
 */
```

### AttributeRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\AttributeRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\ValueRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;

$renderer = new AttributeRenderer('\\App\\MyAttribute', ['foo' => new ValueRenderer('bar')]);
echo $renderer->render(new EntityAliases());
```
```php
#[MyAttribute(foo: 'bar')]
```

### PropertyRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\PropertyRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\Types\BuiltinTypeRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\ValueRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;

$renderer = new PropertyRenderer('myProperty', BuiltinTypeRenderer::Int);
$renderer->setDefault(new ValueRenderer(567));
echo $renderer->render(new EntityAliases());
```
```php
public int $myProperty = 567;
```

### ParameterRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\ParameterRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\Types\BuiltinTypeRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\ValueRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;

$renderer = new ParameterRenderer('myParameter', BuiltinTypeRenderer::Int);
$renderer->setDefault(new ValueRenderer(567));
echo $renderer->render(new EntityAliases());
```
```php
int $myParameter = 567
```

### MethodRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\MethodRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\ParameterRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\Types\BuiltinTypeRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\ValueRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Enums\VisibilityModifierEnum;

$parameterRenderer = new ParameterRenderer('myParameter', BuiltinTypeRenderer::Int);
$parameterRenderer->setDefault(new ValueRenderer(567));

$renderer = new MethodRenderer('myMethod');
$renderer->setVisibilityModifier(VisibilityModifierEnum::Public);
$renderer->addParameter($parameterRenderer);
echo $renderer->render(new EntityAliases());
```
```php
/**
 * @param int $myParameter
 */
public function myMethod(int $myParameter = 567)
{}
```

### ClassRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\ClassRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\MethodRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\ParameterRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\Types\BuiltinTypeRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\ValueRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Enums\VisibilityModifierEnum;

$parameterRenderer = new ParameterRenderer('myParameter', BuiltinTypeRenderer::Int);
$parameterRenderer->setDefault(new ValueRenderer(567));

$methodRenderer = new MethodRenderer('myMethod');
$methodRenderer->setVisibilityModifier(VisibilityModifierEnum::Public);
$methodRenderer->addParameter($parameterRenderer);

$renderer = new ClassRenderer('\\App\\MyClassName');
$renderer->setReadonly();
$renderer->addMethod($methodRenderer);
echo $renderer->render(new EntityAliases());
```
```php
<?php

namespace App;

readonly class MyClassName
{
    /**
     * @param int $myParameter
     */
    public function myMethod(int $myParameter = 567)
    {}
}
```

### TraitRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\TraitRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\MethodRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\ParameterRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\Types\BuiltinTypeRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\ValueRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Enums\VisibilityModifierEnum;

$parameterRenderer = new ParameterRenderer('myParameter', BuiltinTypeRenderer::Int);
$parameterRenderer->setDefault(new ValueRenderer(567));

$methodRenderer = new MethodRenderer('myMethod');
$methodRenderer->setVisibilityModifier(VisibilityModifierEnum::Public);
$methodRenderer->addParameter($parameterRenderer);

$renderer = new TraitRenderer('\\App\\MyTraitName');
$renderer->addMethod($methodRenderer);
echo $renderer->render(new EntityAliases());
```
```php
<?php

namespace App;

trait MyTraitName
{
    /**
     * @param int $myParameter
     */
    public function myMethod(int $myParameter = 567)
    {}
}
```

### InterfaceRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\InterfaceRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\MethodRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\ParameterRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\Types\BuiltinTypeRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\ValueRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Enums\VisibilityModifierEnum;

$parameterRenderer = new ParameterRenderer('myParameter', BuiltinTypeRenderer::Int);
$parameterRenderer->setDefault(new ValueRenderer(567));

$methodRenderer = new MethodRenderer('myMethod');
$methodRenderer->setVisibilityModifier(VisibilityModifierEnum::Public);
$methodRenderer->addParameter($parameterRenderer);

$renderer = new InterfaceRenderer('\\App\\MyInterfaceName');
$renderer->addMethod($methodRenderer);
echo $renderer->render(new EntityAliases());
```
```php
<?php

namespace App;

interface MyInterfaceName
{
    /**
     * @param int $myParameter
     */
    public function myMethod(int $myParameter = 567);
}
```

### EnumCaseRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\EnumCaseRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;

$renderer = new EnumCaseRenderer('MyCase', new ValueRenderer('case_value'));
echo $renderer->render(new EntityAliases());
```
```php
case MyCase = 'case_value';
```

### EnumRenderer
```php
use DarkDarin\PhpEntityRenderer\Renderers\EnumRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\EnumCaseRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\MethodRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\ParameterRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\Types\BuiltinTypeRenderer;
use DarkDarin\PhpEntityRenderer\Renderers\ValueRenderer;
use DarkDarin\PhpEntityRenderer\EntityAliases;
use DarkDarin\PhpEntityRenderer\Enums\VisibilityModifierEnum;

$parameterRenderer = new ParameterRenderer('myParameter', BuiltinTypeRenderer::Int);
$parameterRenderer->setDefault(new ValueRenderer(567));

$methodRenderer = new MethodRenderer('myMethod');
$methodRenderer->setVisibilityModifier(VisibilityModifierEnum::Public);
$methodRenderer->addParameter($parameterRenderer);

$enumFooCase = new EnumCaseRenderer('Foo', new ValueRenderer('foo'));
$enumBarCase = new EnumCaseRenderer('Bar', new ValueRenderer('bar'));

$renderer = new EnumRenderer('\\App\\MyEnumName');
$renderer->addMethod($methodRenderer);
$renderer->addCase($enumFooCase);
$renderer->addCase($enumBarCase);
echo $renderer->render(new EntityAliases());
```
```php
<?php

namespace App;

enum MyEnumName
{
    case Foo = 'foo';
    case Bar = 'bar';
    
    /**
     * @param int $myParameter
     */
    public function myMethod(int $myParameter = 567)
    {}
}
```
