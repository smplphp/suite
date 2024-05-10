<?php
declare(strict_types=1);

namespace Smpl\Logic\Tests\Predicates;

use Override;
use PHPUnit\Framework\TestCase;
use Smpl\Logic\Contracts\Predicate;
use Smpl\Logic\Operations;
use Smpl\Logic\Predicates;
use Smpl\Logic\Predicates\BasePredicate;

/**
 * @group predicates
 * @group base
 */
class BasePredicateTest extends TestCase
{
    /**
     * @var \Smpl\Logic\Predicates\BasePredicate
     */
    private BasePredicate $predicate;

    protected function setUp(): void
    {
        $this->predicate = new class extends BasePredicate {
            #[Override]
            public function test(mixed $value): bool
            {
                return $value === 10.97;
            }
        };
    }

    /**
     * @return void
     *
     * @test
     */
    public function functionCorrectly(): void
    {
        $predicate = $this->predicate;

        $this->assertTrue($predicate->test(10.97));
        $this->assertTrue($predicate->perform(10.97));
        $this->assertTrue($predicate(10.97));

        $this->assertFalse($predicate->test(10.98));
        $this->assertFalse($predicate->perform(10.98));
        $this->assertFalse($predicate(10.98));
    }

    /**
     * @return void
     *
     * @test
     */
    public function areComposableAsAfter(): void
    {
        $predicate = $this->predicate->after(Operations::wrap(fn(float $n): float => $n + 1.4));

        $this->assertTrue($predicate->test(9.57));
        $this->assertTrue($predicate->perform(9.57));
        $this->assertTrue($predicate(9.57));

        $this->assertFalse($predicate->test(10.97));
        $this->assertFalse($predicate->perform(10.97));
        $this->assertFalse($predicate(10.97));
    }

    /**
     * @return void
     *
     * @test
     */
    public function throwsAnExceptionWhenComposedWithBefore(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Predicates cannot be composed as a before operation');

        $this->predicate->before(Operations::wrap(fn(float $n): float => $n + 1.4));
    }

    /**
     * @return void
     *
     * @test
     */
    public function createsLogicalAndCorrectly(): void
    {
        $predicate = $this->predicate->and(Predicates::greaterThan(10));

        $this->assertTrue($predicate->test(10.97));
        $this->assertTrue($predicate->perform(10.97));
        $this->assertTrue($predicate(10.97));

        $this->assertFalse($predicate->test(10.98));
        $this->assertFalse($predicate->perform(10.98));
        $this->assertFalse($predicate(10.98));
    }

    /**
     * @return void
     *
     * @test
     */
    public function createsLogicalOrCorrectly(): void
    {
        $predicate = $this->predicate->or(Predicates::greaterThan(10));

        $this->assertTrue($predicate->test(10.97));
        $this->assertTrue($predicate->perform(10.97));
        $this->assertTrue($predicate(10.97));

        $this->assertTrue($predicate->test(10.98));
        $this->assertTrue($predicate->perform(10.98));
        $this->assertTrue($predicate(10.98));

        $this->assertFalse($predicate->test(6.3));
        $this->assertFalse($predicate->perform(6.3));
        $this->assertFalse($predicate(6.3));
    }

    /**
     * @return void
     *
     * @test
     */
    public function createsLogicalXorCorrectly(): void
    {
        $predicate = $this->predicate->xor(Predicates::greaterThan(10));

        $this->assertFalse($predicate->test(10.97));
        $this->assertFalse($predicate->perform(10.97));
        $this->assertFalse($predicate(10.97));

        $this->assertTrue($predicate->test(10.98));
        $this->assertTrue($predicate->perform(10.98));
        $this->assertTrue($predicate(10.98));

        $this->assertFalse($predicate->test(6.3));
        $this->assertFalse($predicate->perform(6.3));
        $this->assertFalse($predicate(6.3));
    }
}
