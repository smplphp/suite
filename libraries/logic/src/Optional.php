<?php
/** @noinspection UnknownInspectionInspection */
declare(strict_types=1);

namespace Smpl\Logic;

use Smpl\Logic\Contracts\Consumer;
use Smpl\Logic\Contracts\Supplier;
use Smpl\Logic\Exceptions\OptionalException;
use Throwable;

/**
 * Optional
 *
 * Optionals are containers of optional values, and serve as an alternative
 * to returning a nullable value.
 *
 * @template ValType of mixed
 */
final class Optional
{
    /**
     * Create an instance from the value
     *
     * This method creates an optional instance from the provided value if it
     * isn't null, otherwise it returns an empty optional.
     *
     * @template OfType of mixed
     *
     * @param OfType|null $value
     *
     * @return self<OfType>|self<void>
     */
    public static function of(mixed $value): self
    {
        if ($value !== null) {
            return new self($value);
        }

        return self::empty();
    }

    /**
     * Create an instance from the nullable value
     *
     * This method creates an optional instance from the provided value,
     * regardless of whether it's null.
     *
     * @template OfType of mixed
     *
     * @param OfType|null $value
     *
     * @return self<OfType|null>
     */
    public static function ofNullable(mixed $value): self
    {
        return new self($value);
    }

    /**
     * Create an empty instance
     *
     * This method returns an empty 'void' optional instance.
     *
     * @return self<void>
     *
     * @psalm-suppress MixedReturnTypeCoercion
     */
    public static function empty(): self
    {
        return new self();
    }

    /**
     * The optional value
     *
     * @var ValType
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private mixed $value;

    /**
     * The empty state
     *
     * @var bool
     */
    private bool $empty = false;

    /**
     * Create a new instance of the optional class
     *
     * @throws \Smpl\Logic\Exceptions\OptionalException If called with more than one parameter
     */
    private function __construct()
    {
        /**
         * We're ignoring infection results here because it's complaining about
         * an escaped mutation that wouldn't escape.
         *
         * @infection-ignore-all
         */
        if (func_num_args() === 1) {
            /** @psalm-suppress MixedAssignment */
            $this->value = func_get_arg(0);
            $this->empty = false;
        } else if (func_num_args() > 1) {
            /** This should never be reached */
            // @codeCoverageIgnoreStart
            throw OptionalException::tooManyParameters();
            // @codeCoverageIgnoreEnd
        } else {
            $this->empty = true;
        }
    }

    /**
     * Check if the optional is empty
     *
     * Empty optionals were instantiated with no value, not even a null value.
     * Optionals created from null values are not considered empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->empty;
    }

    /**
     * Check if a value is present
     *
     * This method checks that the optional is not empty, and that the value
     * is not null.
     * Empty optionals, or optionals with a null value will return false here.
     *
     * @return bool
     */
    public function isPresent(): bool
    {
        return ! $this->isEmpty() && isset($this->value);
    }

    /**
     * Get the optional value
     *
     * @return ValType
     *
     * @throws \RuntimeException If there is no value
     */
    public function get(): mixed
    {
        if (! $this->isEmpty()) {
            return $this->value;
        }

        throw OptionalException::noValue();
    }

    /**
     * If a value is present, use a consumer
     *
     * This method uses the provided {@see \Smpl\Logic\Contracts\Consumer with
     * its value if a value is present, otherwise it does nothing.
     *
     * @param \Smpl\Logic\Contracts\Consumer<ValType> $consumer
     *
     * @return void
     */
    public function ifPresent(Consumer $consumer): void
    {
        if ($this->isPresent()) {
            $consumer->consume($this->get());
        }
    }

    /**
     * Get the optional value with the provided fallback
     *
     * This method returns the current value if there is one, or the provided
     * fallback value if there isn't one.
     *
     * @template OtherType of mixed
     *
     * @param OtherType|ValType $fallback
     *
     * @return OtherType|ValType
     */
    public function orElse(mixed $fallback): mixed
    {
        return $this->isPresent() ? $this->get() : $fallback;
    }

    /**
     * Get the optional value or use the supplier to get a fallback
     *
     * This method returns the current value if there is one, or the value
     * returned by the provided {@see \Smpl\Logic\Contracts\Supplier}.
     *
     * @template OtherType of mixed
     *
     * @param \Smpl\Logic\Contracts\Supplier<OtherType|ValType> $supplier
     *
     * @return OtherType|ValType
     */
    public function orElseGet(Supplier $supplier): mixed
    {
        return $this->isPresent() ? $this->get() : $supplier->get();
    }

    /**
     * Get the optional value or throw an exception
     *
     * This method returns the current value if there is one, or throws an
     * exception either provided directly, or through a
     * {@see \Smpl\Logic\Contracts\Supplier}.
     *
     * @template ThrowType of \Throwable
     *
     * @param ThrowType|\Smpl\Logic\Contracts\Supplier<ThrowType> $throw
     *
     * @return ValType
     *
     * @throws ThrowType&\Throwable If no value is present
     *
     * @psalm-suppress UndefinedDocblockClass
     *
     * @noinspection   PhpDocSignatureInspection
     */
    public function orElseThrow(Throwable|Supplier $throw): mixed
    {
        if ($this->isPresent()) {
            return $this->get();
        }

        if ($throw instanceof Supplier) {
            /** @var \Smpl\Logic\Contracts\Supplier<ThrowType> $throw */
            throw $throw->get();
        }

        throw $throw;
    }
}
