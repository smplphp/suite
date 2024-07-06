<?php
declare(strict_types=1);

namespace Smpl\Logic\Tests\Predicates;

use PHPUnit\Framework\TestCase;
use Smpl\Logic\Predicates;
use Smpl\Logic\Predicates\LogicalAndPredicate;
use Smpl\Logic\Predicates\ProxyPredicate;

/**
 * @group predicates
 * @group logical
 * @group and
 */
class LogicalAndPredicateTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function logicalAndPredicateTestsCorrectly(): void
    {
        $predicate = new LogicalAndPredicate(
            [
                new ProxyPredicate(fn ($n): bool => is_int($n) && $n % 2 === 0),
                new ProxyPredicate(fn ($n): bool => is_int($n) && $n % 4 === 0),
            ]
        );

        $this->assertTrue($predicate->test(4));
        $this->assertTrue($predicate->test(8));
        $this->assertTrue($predicate->test(12));
        $this->assertTrue($predicate->test(16));
        $this->assertFalse($predicate->test(2));
        $this->assertFalse($predicate->test(6));
        $this->assertFalse($predicate->test(10));
        $this->assertFalse($predicate->test(14));
        $this->assertFalse($predicate->test(4.00));
        $this->assertFalse($predicate->test(8.00));
        $this->assertFalse($predicate->test(12.00));
        $this->assertFalse($predicate->test(16.00));
        $this->assertFalse($predicate->test(20.00));
        $this->assertFalse($predicate->test(4.8));
        $this->assertFalse($predicate->test(12.99999999999));
        $this->assertFalse($predicate->test(false));
        $this->assertFalse($predicate->test(null));
        $this->assertFalse($predicate->test(3));
        $this->assertFalse($predicate->test(true));
        $this->assertFalse($predicate->test([]));
        $this->assertFalse($predicate->test(['yes', 'no']));
        $this->assertFalse($predicate->test([4, 8]));
    }

    /**
     * @return void
     *
     * @test
     */
    public function logicalAndPredicatePerformsCorrectly(): void
    {
        $predicate = new LogicalAndPredicate(
            [
                new ProxyPredicate(fn ($n): bool => is_int($n) && $n % 2 === 0),
                new ProxyPredicate(fn ($n): bool => is_int($n) && $n % 4 === 0),
            ]
        );

        $this->assertTrue($predicate->perform(4));
        $this->assertTrue($predicate->perform(8));
        $this->assertTrue($predicate->perform(12));
        $this->assertTrue($predicate->perform(16));
        $this->assertFalse($predicate->perform(2));
        $this->assertFalse($predicate->perform(6));
        $this->assertFalse($predicate->perform(10));
        $this->assertFalse($predicate->perform(14));
        $this->assertFalse($predicate->perform(4.00));
        $this->assertFalse($predicate->perform(8.00));
        $this->assertFalse($predicate->perform(12.00));
        $this->assertFalse($predicate->perform(16.00));
        $this->assertFalse($predicate->perform(20.00));
        $this->assertFalse($predicate->perform(4.8));
        $this->assertFalse($predicate->perform(12.99999999999));
        $this->assertFalse($predicate->perform(false));
        $this->assertFalse($predicate->perform(null));
        $this->assertFalse($predicate->perform(3));
        $this->assertFalse($predicate->perform(true));
        $this->assertFalse($predicate->perform([]));
        $this->assertFalse($predicate->perform(['yes', 'no']));
        $this->assertFalse($predicate->perform([4, 8]));
    }

    /**
     * @return void
     *
     * @test
     */
    public function logicalAndPredicateInvokesCorrectly(): void
    {
        $predicate = new LogicalAndPredicate(
            [
                new ProxyPredicate(fn ($n): bool => is_int($n) && $n % 2 === 0),
                new ProxyPredicate(fn ($n): bool => is_int($n) && $n % 4 === 0),
            ]
        );

        $this->assertTrue($predicate(4));
        $this->assertTrue($predicate(8));
        $this->assertTrue($predicate(12));
        $this->assertTrue($predicate(16));
        $this->assertFalse($predicate(2));
        $this->assertFalse($predicate(6));
        $this->assertFalse($predicate(10));
        $this->assertFalse($predicate(14));
        $this->assertFalse($predicate(4.00));
        $this->assertFalse($predicate(8.00));
        $this->assertFalse($predicate(12.00));
        $this->assertFalse($predicate(16.00));
        $this->assertFalse($predicate(20.00));
        $this->assertFalse($predicate(4.8));
        $this->assertFalse($predicate(12.99999999999));
        $this->assertFalse($predicate(false));
        $this->assertFalse($predicate(null));
        $this->assertFalse($predicate(3));
        $this->assertFalse($predicate(true));
        $this->assertFalse($predicate([]));
        $this->assertFalse($predicate(['yes', 'no']));
        $this->assertFalse($predicate([4, 8]));
    }

    /**
     * @return void
     *
     * @test
     */
    public function logicalAndPredicateFromHelperTestsCorrectly(): void
    {
        $predicate = Predicates::and(
            new ProxyPredicate(fn ($n): bool => is_int($n) && $n % 2 === 0),
            new ProxyPredicate(fn ($n): bool => is_int($n) && $n % 4 === 0)
        );

        $this->assertTrue($predicate->test(4));
        $this->assertTrue($predicate->test(8));
        $this->assertTrue($predicate->test(12));
        $this->assertTrue($predicate->test(16));
        $this->assertFalse($predicate->test(2));
        $this->assertFalse($predicate->test(6));
        $this->assertFalse($predicate->test(10));
        $this->assertFalse($predicate->test(14));
        $this->assertFalse($predicate->test(4.00));
        $this->assertFalse($predicate->test(8.00));
        $this->assertFalse($predicate->test(12.00));
        $this->assertFalse($predicate->test(16.00));
        $this->assertFalse($predicate->test(20.00));
        $this->assertFalse($predicate->test(4.8));
        $this->assertFalse($predicate->test(12.99999999999));
        $this->assertFalse($predicate->test(false));
        $this->assertFalse($predicate->test(null));
        $this->assertFalse($predicate->test(3));
        $this->assertFalse($predicate->test(true));
        $this->assertFalse($predicate->test([]));
        $this->assertFalse($predicate->test(['yes', 'no']));
        $this->assertFalse($predicate->test([4, 8]));
    }

    /**
     * @return void
     *
     * @test
     */
    public function logicalAndPredicateFromHelperPerformsCorrectly(): void
    {
        $predicate = Predicates::and(
            new ProxyPredicate(fn ($n): bool => is_int($n) && $n % 2 === 0),
            new ProxyPredicate(fn ($n): bool => is_int($n) && $n % 4 === 0)
        );

        $this->assertTrue($predicate->perform(4));
        $this->assertTrue($predicate->perform(8));
        $this->assertTrue($predicate->perform(12));
        $this->assertTrue($predicate->perform(16));
        $this->assertFalse($predicate->perform(2));
        $this->assertFalse($predicate->perform(6));
        $this->assertFalse($predicate->perform(10));
        $this->assertFalse($predicate->perform(14));
        $this->assertFalse($predicate->perform(4.00));
        $this->assertFalse($predicate->perform(8.00));
        $this->assertFalse($predicate->perform(12.00));
        $this->assertFalse($predicate->perform(16.00));
        $this->assertFalse($predicate->perform(20.00));
        $this->assertFalse($predicate->perform(4.8));
        $this->assertFalse($predicate->perform(12.99999999999));
        $this->assertFalse($predicate->perform(false));
        $this->assertFalse($predicate->perform(null));
        $this->assertFalse($predicate->perform(3));
        $this->assertFalse($predicate->perform(true));
        $this->assertFalse($predicate->perform([]));
        $this->assertFalse($predicate->perform(['yes', 'no']));
        $this->assertFalse($predicate->perform([4, 8]));
    }

    /**
     * @return void
     *
     * @test
     */
    public function logicalAndPredicateFromHelperInvokesCorrectly(): void
    {
        $predicate = Predicates::and(
            new ProxyPredicate(fn ($n): bool => is_int($n) && $n % 2 === 0),
            new ProxyPredicate(fn ($n): bool => is_int($n) && $n % 4 === 0)
        );

        $this->assertTrue($predicate(4));
        $this->assertTrue($predicate(8));
        $this->assertTrue($predicate(12));
        $this->assertTrue($predicate(16));
        $this->assertFalse($predicate(2));
        $this->assertFalse($predicate(6));
        $this->assertFalse($predicate(10));
        $this->assertFalse($predicate(14));
        $this->assertFalse($predicate(4.00));
        $this->assertFalse($predicate(8.00));
        $this->assertFalse($predicate(12.00));
        $this->assertFalse($predicate(16.00));
        $this->assertFalse($predicate(20.00));
        $this->assertFalse($predicate(4.8));
        $this->assertFalse($predicate(12.99999999999));
        $this->assertFalse($predicate(false));
        $this->assertFalse($predicate(null));
        $this->assertFalse($predicate(3));
        $this->assertFalse($predicate(true));
        $this->assertFalse($predicate([]));
        $this->assertFalse($predicate(['yes', 'no']));
        $this->assertFalse($predicate([4, 8]));
    }
}
