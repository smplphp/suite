<?php
declare(strict_types=1);

namespace Smpl\Logic\Suppliers;

use Override;
use Smpl\Logic\Contracts\Supplier;

/**
 * Lazy Supplier
 *
 * This supplier provides the call with the result of a callable.
 *
 * @package Logic\Suppliers
 *
 * @template ValType of mixed
 *
 * @implements \Smpl\Logic\Contracts\Supplier<ValType>
 */
final class LazySupplier implements Supplier
{
    /**
     * Create a supplier for the provided value
     *
     * @template SValType of mixed
     *
     * @param callable(): SValType $provider
     *
     * @return self<SValType>
     */
    public static function for(callable $provider): self
    {
        return new self($provider);
    }

    /**
     * The value provider
     *
     * @var callable(): ValType
     */
    private $provider;

    /**
     * The supplier
     *
     * @var \Smpl\Logic\Suppliers\ValueSupplier<ValType>
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private ValueSupplier $value;

    /**
     * Create a new instance of the lazy supplier
     *
     * @param callable(): ValType $provider
     */
    private function __construct(callable $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Get a value
     *
     * @return ValType
     */
    #[Override]
    public function get(): mixed
    {
        /** @psalm-suppress RedundantPropertyInitializationCheck */
        if (! isset($this->value)) {
            $provider = $this->provider;
            $this->value = ValueSupplier::for($provider());
        }

        return $this->value->get();
    }
}
