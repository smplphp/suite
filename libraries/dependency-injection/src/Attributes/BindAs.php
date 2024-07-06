<?php
declare(strict_types=1);

namespace Smpl\DI\Attributes;

use Attribute;

/**
 * Bind As Attribute
 *
 * This attribute should be used on classes to automatically provide binding
 * details.
 *
 * @template BindingAbstract of object
 */
#[Attribute(Attribute::TARGET_CLASS)]
final readonly class BindAs
{
    /**
     * The abstract to be bound as
     *
     * @var class-string<BindingAbstract>
     */
    public string $abstract;

    /**
     * The aliases to be bound as
     *
     * @var array<class-string<BindingAbstract>>
     */
    public array $aliases;

    /**
     * @param class-string<BindingAbstract> $abstract
     * @param class-string<BindingAbstract> ...$aliases
     */
    public function __construct(string $abstract, string ...$aliases)
    {
        $this->abstract = $abstract;
        $this->aliases  = $aliases;
    }
}
