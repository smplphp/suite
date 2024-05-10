<?php
declare(strict_types=1);

namespace Smpl\Logic\Tests\Predicates;

use PHPUnit\Framework\TestCase;
use Smpl\Logic\Operations\ProxyOperation;
use Smpl\Logic\Predicates;
use Smpl\Logic\Predicates\ComposedPredicate;
use Smpl\Logic\Predicates\EqualToPredicate;

/**
 * @group predicates
 * @group composed
 */
class ComposedPredicateTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function composedPredicateTestsCorrectly(): void
    {
        $predicate = new ComposedPredicate(
            new ProxyOperation(fn ($n): int => is_int($n) ? ($n % 4) : -1),
            new EqualToPredicate(0)
        );

        $this->assertTrue($predicate->test(4));
        $this->assertTrue($predicate->test(8));
        $this->assertTrue($predicate->test(12));
        $this->assertTrue($predicate->test(16));
        $this->assertTrue($predicate->test(20));
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
    public function composedPredicatePerformsCorrectly(): void
    {
        $predicate = new ComposedPredicate(
            new ProxyOperation(fn ($n): int => is_int($n) ? ($n % 4) : -1),
            new EqualToPredicate(0)
        );

        $this->assertTrue($predicate->perform(4));
        $this->assertTrue($predicate->perform(8));
        $this->assertTrue($predicate->perform(12));
        $this->assertTrue($predicate->perform(16));
        $this->assertTrue($predicate->perform(20));
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
    public function composedPredicateInvokesCorrectly(): void
    {
        $predicate = new ComposedPredicate(
            new ProxyOperation(fn ($n): int => is_int($n) ? ($n % 4) : -1),
            new EqualToPredicate(0)
        );

        $this->assertTrue($predicate(4));
        $this->assertTrue($predicate(8));
        $this->assertTrue($predicate(12));
        $this->assertTrue($predicate(16));
        $this->assertTrue($predicate(20));
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
    public function composedPredicateFromHelperTestsCorrectly(): void
    {
        $predicate = Predicates::compose(
            new ProxyOperation(fn ($n): int => is_int($n) ? ($n % 4) : -1),
            new EqualToPredicate(0)
        );

        $this->assertTrue($predicate->test(4));
        $this->assertTrue($predicate->test(8));
        $this->assertTrue($predicate->test(12));
        $this->assertTrue($predicate->test(16));
        $this->assertTrue($predicate->test(20));
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
    public function composedPredicateFromHelperPerformsCorrectly(): void
    {
        $predicate = Predicates::compose(
            new ProxyOperation(fn ($n): int => is_int($n) ? ($n % 4) : -1),
            new EqualToPredicate(0)
        );

        $this->assertTrue($predicate->perform(4));
        $this->assertTrue($predicate->perform(8));
        $this->assertTrue($predicate->perform(12));
        $this->assertTrue($predicate->perform(16));
        $this->assertTrue($predicate->perform(20));
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
    public function composedPredicateFromHelperInvokesCorrectly(): void
    {
        $predicate = Predicates::compose(
            new ProxyOperation(fn ($n): int => is_int($n) ? ($n % 4) : -1),
            new EqualToPredicate(0)
        );

        $this->assertTrue($predicate(4));
        $this->assertTrue($predicate(8));
        $this->assertTrue($predicate(12));
        $this->assertTrue($predicate(16));
        $this->assertTrue($predicate(20));
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
