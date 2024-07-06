<?php
declare(strict_types=1);

namespace Smpl\DI\Bindings;

use Smpl\DI\Contracts\Binding;

/**
 * @template BindingAbstract of object
 *
 * @implements \Smpl\DI\Contracts\Binding<BindingAbstract>
 */
final class FactoryBinding implements Binding
{
    /**
     * @var class-string<BindingAbstract>
     */
    private readonly string $abstract;

    /**
     * @var callable(): BindingAbstract
     */
    private $factory;

    /**
     * @var array<class-string<BindingAbstract>>
     */
    private readonly array $aliases;

    private readonly bool $shared;

    /**
     * @param class-string<BindingAbstract>        $abstract
     * @param callable(): BindingAbstract          $factory
     * @param array<class-string<BindingAbstract>> $aliases
     * @param bool                                 $shared
     */
    public function __construct(
        string   $abstract,
        callable $factory,
        array    $aliases,
        bool     $shared
    )
    {
        $this->abstract = $abstract;
        $this->factory  = $factory;
        $this->aliases  = $aliases;
        $this->shared   = $shared;
    }

    /**
     * Get the abstract the binding represents
     *
     * @return class-string<BindingAbstract>
     */
    public function abstract(): string
    {
        return $this->abstract;
    }

    /**
     * Get the concrete the abstract is bound to
     *
     * @return null
     */
    public function concrete(): null
    {
        return null;
    }

    /**
     * Get the aliases of the binding
     *
     * @return array<class-string<BindingAbstract>>
     */
    public function aliases(): array
    {
        return $this->aliases;
    }

    /**
     * Get the factory to be used when resolving this binding
     *
     * @return callable(): BindingAbstract
     * @noinspection ClassMethodNameMatchesFieldNameInspection
     */
    public function factory(): callable
    {
        return $this->factory;
    }

    /**
     * Is the binding shared?
     *
     * @return bool
     */
    public function shared(): bool
    {
        return $this->shared;
    }
}
