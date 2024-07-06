<?php
declare(strict_types=1);

namespace Smpl\DI\Bindings;

use Smpl\DI\Contracts\Binding;

/**
 * @template BindingAbstract of object
 *
 * @implements \Smpl\DI\Contracts\Binding<BindingAbstract>
 */
final readonly class GenericBinding implements Binding
{
    /**
     * @var class-string<BindingAbstract>
     */
    private string $abstract;

    /**
     * @var class-string<BindingAbstract>
     */
    private string $concrete;

    /**
     * @var array<class-string<BindingAbstract>>
     */
    private array $aliases;

    /**
     * @param class-string<BindingAbstract>        $abstract
     * @param class-string<BindingAbstract>        $concrete
     * @param array<class-string<BindingAbstract>> $aliases
     */
    public function __construct(
        string $abstract,
        string $concrete,
        array  $aliases
    )
    {
        $this->abstract = $abstract;
        $this->concrete = $concrete;
        $this->aliases  = $aliases;
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
     * @return class-string<BindingAbstract>
     */
    public function concrete(): string
    {
        return $this->concrete;
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
     * @return null
     */
    public function factory(): null
    {
        return null;
    }

    /**
     * Is the binding shared?
     *
     * @return false
     */
    public function shared(): false
    {
        return false;
    }
}
