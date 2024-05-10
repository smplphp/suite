<?php
declare(strict_types=1);

namespace Smpl\Logic\Tests;

use Override;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Smpl\Logic\Contracts\Consumer;
use Smpl\Logic\Exceptions\OptionalException;
use Smpl\Logic\Optional;
use Smpl\Logic\Suppliers\ValueSupplier;

/**
 * @group logic
 * @group optional
 */
class OptionalTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function canCreateATrulyEmptyOptional(): void
    {
        $empty    = Optional::empty();
        $null     = Optional::of(null);
        $nullable = Optional::ofNullable(null);

        $this->assertTrue($empty->isEmpty());
        $this->assertFalse($empty->isPresent());
        $this->assertTrue($null->isEmpty());
        $this->assertFalse($null->isPresent());
        $this->assertFalse($nullable->isEmpty());
        $this->assertFalse($nullable->isPresent());
        $this->assertNull($nullable->get());
    }

    /**
     * @return void
     *
     * @test
     */
    public function throwsExceptionWhenUsingGetWithNoValuePresent(): void
    {
        $this->expectException(OptionalException::class);
        $this->expectExceptionMessage('The optional has no value');

        Optional::of(null)->get();
    }

    /**
     * @return void
     *
     * @test
     */
    public function canUseGetWithNullableValue(): void
    {
        $optional = Optional::ofNullable(null);

        $this->assertFalse($optional->isEmpty());
        $this->assertFalse($optional->isPresent());
        $this->assertNull($optional->get());
    }

    /**
     * @return void
     *
     * @test
     */
    public function canConsumeValuesIfPresent(): void
    {
        $optional = Optional::of(10);
        $consumer = new class implements Consumer {
            public int $value;

            #[Override]
            public function consume(mixed $arg): void
            {
                $this->value = $arg * 2;
            }
        };

        $optional->ifPresent($consumer);

        $this->assertSame(10, $optional->get());
        $this->assertSame(20, $consumer->value);
    }

    /**
     * @return void
     *
     * @test
     */
    public function canUseFallbackValue(): void
    {
        $present = Optional::of(10);
        $missing = Optional::of(null);

        $this->assertFalse($present->isEmpty());
        $this->assertTrue($present->isPresent());
        $this->assertSame(10, $present->orElse(20));
        $this->assertFalse($missing->isPresent());
        $this->assertTrue($missing->isEmpty());
        $this->assertSame(20, $missing->orElse(20));
    }

    /**
     * @return void
     *
     * @test
     */
    public function canUseSuppliedFallbackValue(): void
    {
        $present  = Optional::of(10);
        $missing  = Optional::of(null);
        $supplier = ValueSupplier::for(20);

        $this->assertSame(20, $supplier->get());
        $this->assertFalse($present->isEmpty());
        $this->assertTrue($present->isPresent());
        $this->assertSame(10, $present->orElseGet($supplier));
        $this->assertFalse($missing->isPresent());
        $this->assertTrue($missing->isEmpty());
        $this->assertSame(20, $missing->orElseGet($supplier));
    }

    /**
     * @return void
     *
     * @test
     */
    public function throwsCustomExceptionIfEmpty(): void
    {
        $present   = Optional::of(10);
        $missing   = Optional::empty();
        $exception = new RuntimeException('There\'s no value!');

        $this->assertTrue($present->isPresent());
        $this->assertFalse($present->isEmpty());
        $this->assertFalse($missing->isPresent());
        $this->assertTrue($missing->isEmpty());

        $this->assertSame(10, $present->orElseThrow($exception));

        $this->expectException($exception::class);
        $this->expectExceptionMessage($exception->getMessage());

        $missing->orElseThrow($exception);
    }

    /**
     * @return void
     *
     * @test
     */
    public function throwsSuppliedCustomExceptionIfEmpty(): void
    {
        $present   = Optional::of(10);
        $missing   = Optional::empty();
        $exception = new RuntimeException('There\'s no value!');
        $supplier  = ValueSupplier::for($exception);

        $this->assertTrue($present->isPresent());
        $this->assertFalse($present->isEmpty());
        $this->assertFalse($missing->isPresent());
        $this->assertTrue($missing->isEmpty());

        $this->assertSame(10, $present->orElseThrow($supplier));

        $this->expectException($exception::class);
        $this->expectExceptionMessage($exception->getMessage());

        $missing->orElseThrow($supplier);
    }
}
