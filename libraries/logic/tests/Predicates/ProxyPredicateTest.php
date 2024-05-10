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
 * @group proxy
 */
class ProxyPredicateTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function wrappingAnonymousFunctionWorksCorrectly(): void
    {
        $predicate = new ProxyPredicate(static fn (int|float $v): bool => ($v % 4) === 0);

        // Use the Predicate::test() method
        $this->assertTrue($predicate->test(4));
        $this->assertTrue($predicate->test(8));
        $this->assertTrue($predicate->test(4.0));
        $this->assertTrue($predicate->test(8.0));
        $this->assertFalse($predicate->test(2));
        $this->assertFalse($predicate->test(3));
        $this->assertFalse($predicate->test(2.0));
        $this->assertFalse($predicate->test(3.0));

        // Use the Operation::perform() method
        $this->assertTrue($predicate->perform(4));
        $this->assertTrue($predicate->perform(8));
        $this->assertTrue($predicate->perform(4.0));
        $this->assertTrue($predicate->perform(8.0));
        $this->assertFalse($predicate->perform(2));
        $this->assertFalse($predicate->perform(3));
        $this->assertFalse($predicate->perform(2.0));
        $this->assertFalse($predicate->perform(3.0));

        // Use the magic __invoke() method
        $this->assertTrue($predicate(4));
        $this->assertTrue($predicate(8));
        $this->assertTrue($predicate(4.0));
        $this->assertTrue($predicate(8.0));
        $this->assertFalse($predicate(2));
        $this->assertFalse($predicate(3));
        $this->assertFalse($predicate(2.0));
        $this->assertFalse($predicate(3.0));
    }

    /**
     * @return void
     *
     * @test
     */
    public function wrappingFunctionWorksCorrectly(): void
    {
        $predicate = new ProxyPredicate('is_array');

        // Use the Predicate::test() method
        $this->assertFalse($predicate->test(0));
        $this->assertTrue($predicate->test([]));
        $this->assertFalse($predicate->test(false));
        $this->assertFalse($predicate->test(null));
        $this->assertFalse($predicate->test(''));
        $this->assertFalse($predicate->test(1));
        $this->assertTrue($predicate->test(['foo']));
        $this->assertFalse($predicate->test(true));
        $this->assertFalse($predicate->test('bar'));

        // Use the Operation::perform() method
        $this->assertFalse($predicate->perform(0));
        $this->assertTrue($predicate->perform([]));
        $this->assertFalse($predicate->perform(false));
        $this->assertFalse($predicate->perform(null));
        $this->assertFalse($predicate->perform(''));
        $this->assertFalse($predicate->perform(1));
        $this->assertTrue($predicate->perform(['foo']));
        $this->assertFalse($predicate->perform(true));
        $this->assertFalse($predicate->perform('bar'));

        // Use the magic __invoke() method
        $this->assertFalse($predicate(0));
        $this->assertTrue($predicate([]));
        $this->assertFalse($predicate(false));
        $this->assertFalse($predicate(null));
        $this->assertFalse($predicate(''));
        $this->assertFalse($predicate(1));
        $this->assertTrue($predicate(['foo']));
        $this->assertFalse($predicate(true));
        $this->assertFalse($predicate('bar'));
    }

    /**
     * @return void
     *
     * @test
     */
    public function wrappingClosureWorksCorrectly(): void
    {
        /** @noinspection PhpClosureCanBeConvertedToFirstClassCallableInspection */
        $predicate = new ProxyPredicate(Closure::fromCallable('is_array'));

        // Use the Predicate::test() method
        $this->assertFalse($predicate->test(0));
        $this->assertTrue($predicate->test([]));
        $this->assertFalse($predicate->test(false));
        $this->assertFalse($predicate->test(null));
        $this->assertFalse($predicate->test(''));
        $this->assertFalse($predicate->test(1));
        $this->assertTrue($predicate->test(['foo']));
        $this->assertFalse($predicate->test(true));
        $this->assertFalse($predicate->test('bar'));

        // Use the Operation::perform() method
        $this->assertFalse($predicate->perform(0));
        $this->assertTrue($predicate->perform([]));
        $this->assertFalse($predicate->perform(false));
        $this->assertFalse($predicate->perform(null));
        $this->assertFalse($predicate->perform(''));
        $this->assertFalse($predicate->perform(1));
        $this->assertTrue($predicate->perform(['foo']));
        $this->assertFalse($predicate->perform(true));
        $this->assertFalse($predicate->perform('bar'));

        // Use the magic __invoke() method
        $this->assertFalse($predicate(0));
        $this->assertTrue($predicate([]));
        $this->assertFalse($predicate(false));
        $this->assertFalse($predicate(null));
        $this->assertFalse($predicate(''));
        $this->assertFalse($predicate(1));
        $this->assertTrue($predicate(['foo']));
        $this->assertFalse($predicate(true));
        $this->assertFalse($predicate('bar'));
    }

    /**
     * @return void
     *
     * @test
     */
    public function wrappingFirstClassCallableWorksCorrectly(): void
    {
        $predicate = new ProxyPredicate(is_array(...));

        // Use the Predicate::test() method
        $this->assertFalse($predicate->test(0));
        $this->assertTrue($predicate->test([]));
        $this->assertFalse($predicate->test(false));
        $this->assertFalse($predicate->test(null));
        $this->assertFalse($predicate->test(''));
        $this->assertFalse($predicate->test(1));
        $this->assertTrue($predicate->test(['foo']));
        $this->assertFalse($predicate->test(true));
        $this->assertFalse($predicate->test('bar'));

        // Use the Operation::perform() method
        $this->assertFalse($predicate->perform(0));
        $this->assertTrue($predicate->perform([]));
        $this->assertFalse($predicate->perform(false));
        $this->assertFalse($predicate->perform(null));
        $this->assertFalse($predicate->perform(''));
        $this->assertFalse($predicate->perform(1));
        $this->assertTrue($predicate->perform(['foo']));
        $this->assertFalse($predicate->perform(true));
        $this->assertFalse($predicate->perform('bar'));

        // Use the magic __invoke() method
        $this->assertFalse($predicate(0));
        $this->assertTrue($predicate([]));
        $this->assertFalse($predicate(false));
        $this->assertFalse($predicate(null));
        $this->assertFalse($predicate(''));
        $this->assertFalse($predicate(1));
        $this->assertTrue($predicate(['foo']));
        $this->assertFalse($predicate(true));
        $this->assertFalse($predicate('bar'));
    }

    /**
     * @return void
     *
     * @test
     */
    public function throwsExceptionWhenWrappingAPredicate(): void
    {
        $this->expectException(PredicateException::class);
        $this->expectExceptionMessage('You cannot wrap a predicate in a predicate');

        new ProxyPredicate(new Predicates\EqualToPredicate(4));
    }

    /**
     * @return void
     *
     * @test
     */
    public function wrappingAnonymousFunctionFromHelperWorksCorrectly(): void
    {
        $predicate = Predicates::wrap(static fn (int|float $v): bool => ($v % 4) === 0);

        // Use the Predicate::test() method
        $this->assertTrue($predicate->test(4));
        $this->assertTrue($predicate->test(8));
        $this->assertTrue($predicate->test(4.0));
        $this->assertTrue($predicate->test(8.0));
        $this->assertFalse($predicate->test(2));
        $this->assertFalse($predicate->test(3));
        $this->assertFalse($predicate->test(2.0));
        $this->assertFalse($predicate->test(3.0));

        // Use the Operation::perform() method
        $this->assertTrue($predicate->perform(4));
        $this->assertTrue($predicate->perform(8));
        $this->assertTrue($predicate->perform(4.0));
        $this->assertTrue($predicate->perform(8.0));
        $this->assertFalse($predicate->perform(2));
        $this->assertFalse($predicate->perform(3));
        $this->assertFalse($predicate->perform(2.0));
        $this->assertFalse($predicate->perform(3.0));

        // Use the magic __invoke() method
        $this->assertTrue($predicate(4));
        $this->assertTrue($predicate(8));
        $this->assertTrue($predicate(4.0));
        $this->assertTrue($predicate(8.0));
        $this->assertFalse($predicate(2));
        $this->assertFalse($predicate(3));
        $this->assertFalse($predicate(2.0));
        $this->assertFalse($predicate(3.0));
    }

    /**
     * @return void
     *
     * @test
     */
    public function wrappingFunctionFromHelperWorksCorrectly(): void
    {
        $predicate = Predicates::wrap('is_array');

        // Use the Predicate::test() method
        $this->assertFalse($predicate->test(0));
        $this->assertTrue($predicate->test([]));
        $this->assertFalse($predicate->test(false));
        $this->assertFalse($predicate->test(null));
        $this->assertFalse($predicate->test(''));
        $this->assertFalse($predicate->test(1));
        $this->assertTrue($predicate->test(['foo']));
        $this->assertFalse($predicate->test(true));
        $this->assertFalse($predicate->test('bar'));

        // Use the Operation::perform() method
        $this->assertFalse($predicate->perform(0));
        $this->assertTrue($predicate->perform([]));
        $this->assertFalse($predicate->perform(false));
        $this->assertFalse($predicate->perform(null));
        $this->assertFalse($predicate->perform(''));
        $this->assertFalse($predicate->perform(1));
        $this->assertTrue($predicate->perform(['foo']));
        $this->assertFalse($predicate->perform(true));
        $this->assertFalse($predicate->perform('bar'));

        // Use the magic __invoke() method
        $this->assertFalse($predicate(0));
        $this->assertTrue($predicate([]));
        $this->assertFalse($predicate(false));
        $this->assertFalse($predicate(null));
        $this->assertFalse($predicate(''));
        $this->assertFalse($predicate(1));
        $this->assertTrue($predicate(['foo']));
        $this->assertFalse($predicate(true));
        $this->assertFalse($predicate('bar'));
    }

    /**
     * @return void
     *
     * @test
     */
    public function wrappingClosureFromHelperWorksCorrectly(): void
    {
        /** @noinspection PhpClosureCanBeConvertedToFirstClassCallableInspection */
        $predicate = Predicates::wrap(Closure::fromCallable('is_array'));

        // Use the Predicate::test() method
        $this->assertFalse($predicate->test(0));
        $this->assertTrue($predicate->test([]));
        $this->assertFalse($predicate->test(false));
        $this->assertFalse($predicate->test(null));
        $this->assertFalse($predicate->test(''));
        $this->assertFalse($predicate->test(1));
        $this->assertTrue($predicate->test(['foo']));
        $this->assertFalse($predicate->test(true));
        $this->assertFalse($predicate->test('bar'));

        // Use the Operation::perform() method
        $this->assertFalse($predicate->perform(0));
        $this->assertTrue($predicate->perform([]));
        $this->assertFalse($predicate->perform(false));
        $this->assertFalse($predicate->perform(null));
        $this->assertFalse($predicate->perform(''));
        $this->assertFalse($predicate->perform(1));
        $this->assertTrue($predicate->perform(['foo']));
        $this->assertFalse($predicate->perform(true));
        $this->assertFalse($predicate->perform('bar'));

        // Use the magic __invoke() method
        $this->assertFalse($predicate(0));
        $this->assertTrue($predicate([]));
        $this->assertFalse($predicate(false));
        $this->assertFalse($predicate(null));
        $this->assertFalse($predicate(''));
        $this->assertFalse($predicate(1));
        $this->assertTrue($predicate(['foo']));
        $this->assertFalse($predicate(true));
        $this->assertFalse($predicate('bar'));
    }

    /**
     * @return void
     *
     * @test
     */
    public function wrappingFirstClassCallableFromHelperWorksCorrectly(): void
    {
        $predicate = Predicates::wrap(is_array(...));

        // Use the Predicate::test() method
        $this->assertFalse($predicate->test(0));
        $this->assertTrue($predicate->test([]));
        $this->assertFalse($predicate->test(false));
        $this->assertFalse($predicate->test(null));
        $this->assertFalse($predicate->test(''));
        $this->assertFalse($predicate->test(1));
        $this->assertTrue($predicate->test(['foo']));
        $this->assertFalse($predicate->test(true));
        $this->assertFalse($predicate->test('bar'));

        // Use the Operation::perform() method
        $this->assertFalse($predicate->perform(0));
        $this->assertTrue($predicate->perform([]));
        $this->assertFalse($predicate->perform(false));
        $this->assertFalse($predicate->perform(null));
        $this->assertFalse($predicate->perform(''));
        $this->assertFalse($predicate->perform(1));
        $this->assertTrue($predicate->perform(['foo']));
        $this->assertFalse($predicate->perform(true));
        $this->assertFalse($predicate->perform('bar'));

        // Use the magic __invoke() method
        $this->assertFalse($predicate(0));
        $this->assertTrue($predicate([]));
        $this->assertFalse($predicate(false));
        $this->assertFalse($predicate(null));
        $this->assertFalse($predicate(''));
        $this->assertFalse($predicate(1));
        $this->assertTrue($predicate(['foo']));
        $this->assertFalse($predicate(true));
        $this->assertFalse($predicate('bar'));
    }

    /**
     * @return void
     *
     * @test
     */
    public function helperReturnsThePredicateWhenAttemptingToWrapIt(): void
    {
        $predicate1 = new Predicates\EqualToPredicate(4);
        $predicate2 = Predicates::wrap($predicate1);

        $this->assertSame($predicate1, $predicate2);
        $this->assertEquals($predicate1, $predicate2);
    }
}
