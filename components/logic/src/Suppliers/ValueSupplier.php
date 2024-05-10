<?php
declare(strict_types=1);

namespace Smpl\Logic\Suppliers;

use Override;
use Smpl\Logic\Contracts\Supplier;

/**
 * Value Supplier
 *
 * This supplier provides the call with a predefined value.
 *
 * @package Logic\Suppliers
 *
 * @template ValType of mixed
 *
 * @implements \Smpl\Logic\Contracts\Supplier<ValType>
 */
final class ValueSupplier implements Supplier
{
    /**
     * Create a supplier for the provided value
     *
     * @template SValType of mixed
     *
     * @param SValType $value
     *
     * @return self<SValType>
     */
    public static function for(mixed $value): self
    {
        return new self($value);
    }

    /**
     * The value being supplied
     *
     * @var ValType
     */
    private mixed $value;

    /**
     * Create a new instance of the value supplier
     *
     * @param ValType $value
     */
    private function __construct(mixed $value)
    {
        $this->value = $value;
    }

    /**
     * Get a value
     *
     * @return ValType
     */
    #[Override]
    public function get(): mixed
    {
        return $this->value;
    }
}
