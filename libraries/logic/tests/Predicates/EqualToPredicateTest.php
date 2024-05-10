<?php
declare(strict_types=1);

namespace Smpl\Logic\Tests\Predicates;

use Closure;
use PHPUnit\Framework\TestCase;
use Smpl\Logic\Exceptions\PredicateException;
use Smpl\Logic\Predicates;
use Smpl\Logic\Predicates\ProxyPredicate;

/**
 * @group predicate
 * @group comparison
 */
class EqualToPredicateTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function truthyValuesWorkCorrectly(): void
    {
        $predicate = new Predicates\EqualToPredicate(true);

        // Use the Predicate::test() method
        $this->assertTrue($predicate->test(true));
        $this->assertTrue($predicate->test(1));
        $this->assertTrue($predicate->test(4.0));
        $this->assertTrue($predicate->test('true'));
        $this->assertTrue($predicate->test('false'));
        $this->assertTrue($predicate->test('null'));
        $this->assertTrue($predicate->test(['foo']));
        $this->assertFalse($predicate->test(false));
        $this->assertFalse($predicate->test(0));
        $this->assertFalse($predicate->test(''));
        $this->assertFalse($predicate->test(null));

        // Use the Operation::perform() method
        $this->assertTrue($predicate->perform(true));
        $this->assertTrue($predicate->perform(1));
        $this->assertTrue($predicate->perform(4.0));
        $this->assertTrue($predicate->perform('true'));
        $this->assertTrue($predicate->perform('false'));
        $this->assertTrue($predicate->perform('null'));
        $this->assertTrue($predicate->perform(['foo']));
        $this->assertFalse($predicate->perform(false));
        $this->assertFalse($predicate->perform(0));
        $this->assertFalse($predicate->perform(''));
        $this->assertFalse($predicate->perform(null));

        // Use the magic __invoke() method
        $this->assertTrue($predicate(true));
        $this->assertTrue($predicate(1));
        $this->assertTrue($predicate(4.0));
        $this->assertTrue($predicate('true'));
        $this->assertTrue($predicate('false'));
        $this->assertTrue($predicate('null'));
        $this->assertTrue($predicate(['foo']));
        $this->assertFalse($predicate(false));
        $this->assertFalse($predicate(0));
        $this->assertFalse($predicate(''));
        $this->assertFalse($predicate(null));
    }

    /**
     * @return void
     *
     * @test
     */
    public function falseyValuesWorkCorrectly(): void
    {
        $predicate = new Predicates\EqualToPredicate(false);

        // Use the Predicate::test() method
        $this->assertFalse($predicate->test(true));
        $this->assertFalse($predicate->test(1));
        $this->assertFalse($predicate->test(4.0));
        $this->assertFalse($predicate->test('true'));
        $this->assertFalse($predicate->test('false'));
        $this->assertFalse($predicate->test('null'));
        $this->assertFalse($predicate->test(['foo']));
        $this->assertTrue($predicate->test(false));
        $this->assertTrue($predicate->test(0));
        $this->assertTrue($predicate->test(''));
        $this->assertTrue($predicate->test(null));

        // Use the Operation::perform() method
        $this->assertFalse($predicate->perform(true));
        $this->assertFalse($predicate->perform(1));
        $this->assertFalse($predicate->perform(4.0));
        $this->assertFalse($predicate->perform('true'));
        $this->assertFalse($predicate->perform('false'));
        $this->assertFalse($predicate->perform('null'));
        $this->assertFalse($predicate->perform(['foo']));
        $this->assertTrue($predicate->perform(false));
        $this->assertTrue($predicate->perform(0));
        $this->assertTrue($predicate->perform(''));
        $this->assertTrue($predicate->perform(null));

        // Use the magic __invoke() method
        $this->assertFalse($predicate(true));
        $this->assertFalse($predicate(1));
        $this->assertFalse($predicate(4.0));
        $this->assertFalse($predicate('true'));
        $this->assertFalse($predicate('false'));
        $this->assertFalse($predicate('null'));
        $this->assertFalse($predicate(['foo']));
        $this->assertTrue($predicate(false));
        $this->assertTrue($predicate(0));
        $this->assertTrue($predicate(''));
        $this->assertTrue($predicate(null));
    }

    /**
     * @return void
     *
     * @test
     */
    public function truthyValuesWorkCorrectlyFromHelper(): void
    {
        $predicate = Predicates::equalTo(true);

        // Use the Predicate::test() method
        $this->assertTrue($predicate->test(true));
        $this->assertTrue($predicate->test(1));
        $this->assertTrue($predicate->test(4.0));
        $this->assertTrue($predicate->test('true'));
        $this->assertTrue($predicate->test('false'));
        $this->assertTrue($predicate->test('null'));
        $this->assertTrue($predicate->test(['foo']));
        $this->assertFalse($predicate->test(false));
        $this->assertFalse($predicate->test(0));
        $this->assertFalse($predicate->test(''));
        $this->assertFalse($predicate->test(null));

        // Use the Operation::perform() method
        $this->assertTrue($predicate->perform(true));
        $this->assertTrue($predicate->perform(1));
        $this->assertTrue($predicate->perform(4.0));
        $this->assertTrue($predicate->perform('true'));
        $this->assertTrue($predicate->perform('false'));
        $this->assertTrue($predicate->perform('null'));
        $this->assertTrue($predicate->perform(['foo']));
        $this->assertFalse($predicate->perform(false));
        $this->assertFalse($predicate->perform(0));
        $this->assertFalse($predicate->perform(''));
        $this->assertFalse($predicate->perform(null));

        // Use the magic __invoke() method
        $this->assertTrue($predicate(true));
        $this->assertTrue($predicate(1));
        $this->assertTrue($predicate(4.0));
        $this->assertTrue($predicate('true'));
        $this->assertTrue($predicate('false'));
        $this->assertTrue($predicate('null'));
        $this->assertTrue($predicate(['foo']));
        $this->assertFalse($predicate(false));
        $this->assertFalse($predicate(0));
        $this->assertFalse($predicate(''));
        $this->assertFalse($predicate(null));
    }

    /**
     * @return void
     *
     * @test
     */
    public function falseyValuesWorkCorrectlyFromHelper(): void
    {
        $predicate = Predicates::equalTo(false);

        // Use the Predicate::test() method
        $this->assertFalse($predicate->test(true));
        $this->assertFalse($predicate->test(1));
        $this->assertFalse($predicate->test(4.0));
        $this->assertFalse($predicate->test('true'));
        $this->assertFalse($predicate->test('false'));
        $this->assertFalse($predicate->test('null'));
        $this->assertFalse($predicate->test(['foo']));
        $this->assertTrue($predicate->test(false));
        $this->assertTrue($predicate->test(0));
        $this->assertTrue($predicate->test(''));
        $this->assertTrue($predicate->test(null));

        // Use the Operation::perform() method
        $this->assertFalse($predicate->perform(true));
        $this->assertFalse($predicate->perform(1));
        $this->assertFalse($predicate->perform(4.0));
        $this->assertFalse($predicate->perform('true'));
        $this->assertFalse($predicate->perform('false'));
        $this->assertFalse($predicate->perform('null'));
        $this->assertFalse($predicate->perform(['foo']));
        $this->assertTrue($predicate->perform(false));
        $this->assertTrue($predicate->perform(0));
        $this->assertTrue($predicate->perform(''));
        $this->assertTrue($predicate->perform(null));

        // Use the magic __invoke() method
        $this->assertFalse($predicate(true));
        $this->assertFalse($predicate(1));
        $this->assertFalse($predicate(4.0));
        $this->assertFalse($predicate('true'));
        $this->assertFalse($predicate('false'));
        $this->assertFalse($predicate('null'));
        $this->assertFalse($predicate(['foo']));
        $this->assertTrue($predicate(false));
        $this->assertTrue($predicate(0));
        $this->assertTrue($predicate(''));
        $this->assertTrue($predicate(null));
    }
}
