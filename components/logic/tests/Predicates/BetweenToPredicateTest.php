<?php
declare(strict_types=1);

namespace Smpl\Logic\Tests\Predicates;

use PHPUnit\Framework\TestCase;
use Smpl\Logic\Predicates;

/**
 * @group predicates
 * @group numerical
 * @group range
 */
class BetweenToPredicateTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function betweenPredicateTestsCorrectly(): void
    {
        $predicate = Predicates::between(2, 10);

        $this->assertFalse($predicate->test(0));
        $this->assertFalse($predicate->test(1));
        $this->assertFalse($predicate->test(2));
        $this->assertTrue($predicate->test(3));
        $this->assertTrue($predicate->test(4));
        $this->assertTrue($predicate->test(5));
        $this->assertTrue($predicate->test(6));
        $this->assertTrue($predicate->test(7));
        $this->assertTrue($predicate->test(8));
        $this->assertTrue($predicate->test(9));
        $this->assertFalse($predicate->test(10));
        $this->assertFalse($predicate->test(11));
        $this->assertFalse($predicate->test(12));
        $this->assertFalse($predicate->test(13));

        $this->assertFalse($predicate->test(true));
        $this->assertTrue($predicate->test(4.0));
        $this->assertFalse($predicate->test(10.9));
        $this->assertFalse($predicate->test('true'));
        $this->assertFalse($predicate->test('false'));
        $this->assertFalse($predicate->test('null'));
        $this->assertFalse($predicate->test(['foo']));
        $this->assertFalse($predicate->test(false));
        $this->assertFalse($predicate->test(''));
        $this->assertFalse($predicate->test(null));
    }

    /**
     * @return void
     *
     * @test
     */
    public function betweenPredicatePerformsCorrectly(): void
    {
        $predicate = Predicates::between(2, 10);

        $this->assertFalse($predicate->perform(0));
        $this->assertFalse($predicate->perform(1));
        $this->assertFalse($predicate->perform(2));
        $this->assertTrue($predicate->perform(3));
        $this->assertTrue($predicate->perform(4));
        $this->assertTrue($predicate->perform(5));
        $this->assertTrue($predicate->perform(6));
        $this->assertTrue($predicate->perform(7));
        $this->assertTrue($predicate->perform(8));
        $this->assertTrue($predicate->perform(9));
        $this->assertFalse($predicate->perform(10));
        $this->assertFalse($predicate->perform(11));
        $this->assertFalse($predicate->perform(12));
        $this->assertFalse($predicate->perform(13));

        $this->assertFalse($predicate->perform(true));
        $this->assertTrue($predicate->perform(4.0));
        $this->assertFalse($predicate->perform(10.9));
        $this->assertFalse($predicate->perform('true'));
        $this->assertFalse($predicate->perform('false'));
        $this->assertFalse($predicate->perform('null'));
        $this->assertFalse($predicate->perform(['foo']));
        $this->assertFalse($predicate->perform(false));
        $this->assertFalse($predicate->perform(''));
        $this->assertFalse($predicate->perform(null));
    }

    /**
     * @return void
     *
     * @test
     */
    public function betweenPredicateInvokesCorrectly(): void
    {
        $predicate = Predicates::between(2, 10);

        $this->assertFalse($predicate(0));
        $this->assertFalse($predicate(1));
        $this->assertFalse($predicate(2));
        $this->assertTrue($predicate(3));
        $this->assertTrue($predicate(4));
        $this->assertTrue($predicate(5));
        $this->assertTrue($predicate(6));
        $this->assertTrue($predicate(7));
        $this->assertTrue($predicate(8));
        $this->assertTrue($predicate(9));
        $this->assertFalse($predicate(10));
        $this->assertFalse($predicate(11));
        $this->assertFalse($predicate(12));
        $this->assertFalse($predicate(13));

        $this->assertFalse($predicate(true));
        $this->assertTrue($predicate(4.0));
        $this->assertFalse($predicate(10.9));
        $this->assertFalse($predicate('true'));
        $this->assertFalse($predicate('false'));
        $this->assertFalse($predicate('null'));
        $this->assertFalse($predicate(['foo']));
        $this->assertFalse($predicate(false));
        $this->assertFalse($predicate(''));
        $this->assertFalse($predicate(null));
    }
}
