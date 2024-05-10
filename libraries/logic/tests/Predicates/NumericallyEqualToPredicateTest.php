<?php
declare(strict_types=1);

namespace Smpl\Logic\Tests\Predicates;

use Countable;
use Override;
use PHPUnit\Framework\TestCase;
use Smpl\Logic\Predicates;

/**
 * @group predicate
 * @group comparison
 * @group numerical
 */
class NumericallyEqualToPredicateTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function correctResultFromTestedInteger(): void
    {
        $predicate = Predicates::numericallyEqualTo(10);

        // Use the Predicate::test() method
        $this->assertFalse($predicate->test(true));
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
        $this->assertTrue($predicate->test(10));
        $this->assertTrue($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 10;
            }
        }));
        $this->assertFalse($predicate->test(11));
        $this->assertFalse($predicate->test(9.99999));
        $this->assertFalse($predicate->test(4000));
        $this->assertFalse($predicate->test(6_000_000));
        $this->assertFalse($predicate->test(10E7));
        $this->assertFalse($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 7;
            }
        }));

        // Use the Operation::perform() method
        $this->assertFalse($predicate->perform(true));
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
        $this->assertTrue($predicate->perform(10));
        $this->assertTrue($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 10;
            }
        }));
        $this->assertFalse($predicate->perform(11));
        $this->assertFalse($predicate->perform(9.99999));
        $this->assertFalse($predicate->perform(4000));
        $this->assertFalse($predicate->perform(6_000_000));
        $this->assertFalse($predicate->perform(10E7));
        $this->assertFalse($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 7;
            }
        }));

        // Use the magic __invoke() method
        $this->assertFalse($predicate(true));
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
        $this->assertTrue($predicate(10));
        $this->assertTrue($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 10;
            }
        }));
        $this->assertFalse($predicate(11));
        $this->assertFalse($predicate(9.99999));
        $this->assertFalse($predicate(4000));
        $this->assertFalse($predicate(6_000_000));
        $this->assertFalse($predicate(10E7));
        $this->assertFalse($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 7;
            }
        }));
    }

    /**
     * @return void
     *
     * @test
     */
    public function correctResultFromTestedFloat(): void
    {
        $predicate = Predicates::numericallyEqualTo(10.8);

        // Use the Predicate::test() method
        $this->assertFalse($predicate->test(true));
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
        $this->assertTrue($predicate->test(10.8));
        $this->assertFalse($predicate->test(11));
        $this->assertFalse($predicate->test(9.99999));
        $this->assertFalse($predicate->test(4000));
        $this->assertFalse($predicate->test(6_000_000));
        $this->assertFalse($predicate->test(10E7));
        $this->assertFalse($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 7;
            }
        }));

        // Use the Operation::perform() method
        $this->assertFalse($predicate->perform(true));
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
        $this->assertTrue($predicate->perform(10.8));
        $this->assertFalse($predicate->perform(11));
        $this->assertFalse($predicate->perform(9.99999));
        $this->assertFalse($predicate->perform(4000));
        $this->assertFalse($predicate->perform(6_000_000));
        $this->assertFalse($predicate->perform(10E7));
        $this->assertFalse($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 7;
            }
        }));

        // Use the magic __invoke() method
        $this->assertFalse($predicate(true));
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
        $this->assertTrue($predicate(10.8));
        $this->assertFalse($predicate(11));
        $this->assertFalse($predicate(9.99999));
        $this->assertFalse($predicate(4000));
        $this->assertFalse($predicate(6_000_000));
        $this->assertFalse($predicate(10E7));
        $this->assertFalse($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 7;
            }
        }));
    }

    /**
     * @return void
     *
     * @test
     */
    public function correctResultFromTestedCountable(): void
    {
        $predicate = Predicates::numericallyEqualTo(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 10;
            }
        });

        // Use the Predicate::test() method
        $this->assertFalse($predicate->test(true));
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
        $this->assertTrue($predicate->test(10));
        $this->assertTrue($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 10;
            }
        }));
        $this->assertFalse($predicate->test(11));
        $this->assertFalse($predicate->test(9.99999));
        $this->assertFalse($predicate->test(4000));
        $this->assertFalse($predicate->test(6_000_000));
        $this->assertFalse($predicate->test(10E7));
        $this->assertFalse($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 7;
            }
        }));

        // Use the Operation::perform() method
        $this->assertFalse($predicate->perform(true));
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
        $this->assertTrue($predicate->perform(10));
        $this->assertTrue($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 10;
            }
        }));
        $this->assertFalse($predicate->perform(11));
        $this->assertFalse($predicate->perform(9.99999));
        $this->assertFalse($predicate->perform(4000));
        $this->assertFalse($predicate->perform(6_000_000));
        $this->assertFalse($predicate->perform(10E7));
        $this->assertFalse($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 7;
            }
        }));

        // Use the magic __invoke() method
        $this->assertFalse($predicate(true));
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
        $this->assertTrue($predicate(10));
        $this->assertTrue($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 10;
            }
        }));
        $this->assertFalse($predicate(11));
        $this->assertFalse($predicate(9.99999));
        $this->assertFalse($predicate(4000));
        $this->assertFalse($predicate(6_000_000));
        $this->assertFalse($predicate(10E7));
        $this->assertFalse($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 7;
            }
        }));
    }
}
