<?php
declare(strict_types=1);

namespace Smpl\Logic\Tests\Predicates;

use PHPUnit\Framework\TestCase;
use Smpl\Logic\Predicates;

/**
 * @group predicate
 * @group comparison
 */
class SameAsPredicateTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function trueValuesWorkCorrectly(): void
    {
        $predicate = new Predicates\SameAsPredicate(true);

        // Use the Predicate::test() method
        $this->assertTrue($predicate->test(true));
        $this->assertFalse($predicate->test(1));
        $this->assertFalse($predicate->test(4.0));
        $this->assertFalse($predicate->test('true'));
        $this->assertFalse($predicate->test('false'));
        $this->assertFalse($predicate->test('null'));
        $this->assertFalse($predicate->test(['foo']));
        $this->assertFalse($predicate->test(false));
        $this->assertFalse($predicate->test(0));
        $this->assertFalse($predicate->test(''));
        $this->assertFalse($predicate->test(null));

        // Use the Operation::perform() method
        $this->assertTrue($predicate->perform(true));
        $this->assertFalse($predicate->perform(1));
        $this->assertFalse($predicate->perform(4.0));
        $this->assertFalse($predicate->perform('true'));
        $this->assertFalse($predicate->perform('false'));
        $this->assertFalse($predicate->perform('null'));
        $this->assertFalse($predicate->perform(['foo']));
        $this->assertFalse($predicate->perform(false));
        $this->assertFalse($predicate->perform(0));
        $this->assertFalse($predicate->perform(''));
        $this->assertFalse($predicate->perform(null));

        // Use the magic __invoke() method
        $this->assertTrue($predicate(true));
        $this->assertFalse($predicate(1));
        $this->assertFalse($predicate(4.0));
        $this->assertFalse($predicate('true'));
        $this->assertFalse($predicate('false'));
        $this->assertFalse($predicate('null'));
        $this->assertFalse($predicate(['foo']));
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
    public function falseValuesWorkCorrectly(): void
    {
        $predicate = new Predicates\SameAsPredicate(false);

        // Use the Predicate::test() method
        $this->assertFalse($predicate->test(true));
        $this->assertFalse($predicate->test(1));
        $this->assertFalse($predicate->test(4.0));
        $this->assertFalse($predicate->test('true'));
        $this->assertFalse($predicate->test('false'));
        $this->assertFalse($predicate->test('null'));
        $this->assertFalse($predicate->test(['foo']));
        $this->assertTrue($predicate->test(false));
        $this->assertFalse($predicate->test(0));
        $this->assertFalse($predicate->test(''));
        $this->assertFalse($predicate->test(null));

        // Use the Operation::perform() method
        $this->assertFalse($predicate->perform(true));
        $this->assertFalse($predicate->perform(1));
        $this->assertFalse($predicate->perform(4.0));
        $this->assertFalse($predicate->perform('true'));
        $this->assertFalse($predicate->perform('false'));
        $this->assertFalse($predicate->perform('null'));
        $this->assertFalse($predicate->perform(['foo']));
        $this->assertTrue($predicate->perform(false));
        $this->assertFalse($predicate->perform(0));
        $this->assertFalse($predicate->perform(''));
        $this->assertFalse($predicate->perform(null));

        // Use the magic __invoke() method
        $this->assertFalse($predicate(true));
        $this->assertFalse($predicate(1));
        $this->assertFalse($predicate(4.0));
        $this->assertFalse($predicate('true'));
        $this->assertFalse($predicate('false'));
        $this->assertFalse($predicate('null'));
        $this->assertFalse($predicate(['foo']));
        $this->assertTrue($predicate(false));
        $this->assertFalse($predicate(0));
        $this->assertFalse($predicate(''));
        $this->assertFalse($predicate(null));
    }

    /**
     * @return void
     *
     * @test
     */
    public function trueValuesWorkCorrectlyFromHelper(): void
    {
        $predicate = Predicates::sameAs(true);

        // Use the Predicate::test() method
        $this->assertTrue($predicate->test(true));
        $this->assertFalse($predicate->test(1));
        $this->assertFalse($predicate->test(4.0));
        $this->assertFalse($predicate->test('true'));
        $this->assertFalse($predicate->test('false'));
        $this->assertFalse($predicate->test('null'));
        $this->assertFalse($predicate->test(['foo']));
        $this->assertFalse($predicate->test(false));
        $this->assertFalse($predicate->test(0));
        $this->assertFalse($predicate->test(''));
        $this->assertFalse($predicate->test(null));

        // Use the Operation::perform() method
        $this->assertTrue($predicate->perform(true));
        $this->assertFalse($predicate->perform(1));
        $this->assertFalse($predicate->perform(4.0));
        $this->assertFalse($predicate->perform('true'));
        $this->assertFalse($predicate->perform('false'));
        $this->assertFalse($predicate->perform('null'));
        $this->assertFalse($predicate->perform(['foo']));
        $this->assertFalse($predicate->perform(false));
        $this->assertFalse($predicate->perform(0));
        $this->assertFalse($predicate->perform(''));
        $this->assertFalse($predicate->perform(null));

        // Use the magic __invoke() method
        $this->assertTrue($predicate(true));
        $this->assertFalse($predicate(1));
        $this->assertFalse($predicate(4.0));
        $this->assertFalse($predicate('true'));
        $this->assertFalse($predicate('false'));
        $this->assertFalse($predicate('null'));
        $this->assertFalse($predicate(['foo']));
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
    public function falseValuesWorkCorrectlyFromHelper(): void
    {
        $predicate = Predicates::sameAs(false);

        // Use the Predicate::test() method
        $this->assertFalse($predicate->test(true));
        $this->assertFalse($predicate->test(1));
        $this->assertFalse($predicate->test(4.0));
        $this->assertFalse($predicate->test('true'));
        $this->assertFalse($predicate->test('false'));
        $this->assertFalse($predicate->test('null'));
        $this->assertFalse($predicate->test(['foo']));
        $this->assertTrue($predicate->test(false));
        $this->assertFalse($predicate->test(0));
        $this->assertFalse($predicate->test(''));
        $this->assertFalse($predicate->test(null));

        // Use the Operation::perform() method
        $this->assertFalse($predicate->perform(true));
        $this->assertFalse($predicate->perform(1));
        $this->assertFalse($predicate->perform(4.0));
        $this->assertFalse($predicate->perform('true'));
        $this->assertFalse($predicate->perform('false'));
        $this->assertFalse($predicate->perform('null'));
        $this->assertFalse($predicate->perform(['foo']));
        $this->assertTrue($predicate->perform(false));
        $this->assertFalse($predicate->perform(0));
        $this->assertFalse($predicate->perform(''));
        $this->assertFalse($predicate->perform(null));

        // Use the magic __invoke() method
        $this->assertFalse($predicate(true));
        $this->assertFalse($predicate(1));
        $this->assertFalse($predicate(4.0));
        $this->assertFalse($predicate('true'));
        $this->assertFalse($predicate('false'));
        $this->assertFalse($predicate('null'));
        $this->assertFalse($predicate(['foo']));
        $this->assertTrue($predicate(false));
        $this->assertFalse($predicate(0));
        $this->assertFalse($predicate(''));
        $this->assertFalse($predicate(null));
    }
}
