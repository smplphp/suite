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
class GreaterThanPredicateTest extends TestCase
{
    /**
     * @return void
     *
     * @test
     */
    public function correctResultFromTestedInteger(): void
    {
        $predicate = new Predicates\GreaterThanPredicate(10);

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
        $this->assertFalse($predicate->test(10));
        $this->assertFalse($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate->test(11));
        $this->assertTrue($predicate->test(10.0000001));
        $this->assertTrue($predicate->test(4000));
        $this->assertTrue($predicate->test(6_000_000));
        $this->assertTrue($predicate->test(10E7));
        $this->assertTrue($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
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
        $this->assertFalse($predicate->perform(10));
        $this->assertFalse($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate->perform(11));
        $this->assertTrue($predicate->perform(10.0000001));
        $this->assertTrue($predicate->perform(4000));
        $this->assertTrue($predicate->perform(6_000_000));
        $this->assertTrue($predicate->perform(10E7));
        $this->assertTrue($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
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
        $this->assertFalse($predicate(10));
        $this->assertFalse($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate(11));
        $this->assertTrue($predicate(10.0000001));
        $this->assertTrue($predicate(4000));
        $this->assertTrue($predicate(6_000_000));
        $this->assertTrue($predicate(10E7));
        $this->assertTrue($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
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
        $predicate = new Predicates\GreaterThanPredicate(10.8);

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
        $this->assertFalse($predicate->test(10));
        $this->assertFalse($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate->test(11));
        $this->assertFalse($predicate->test(10.0000001));
        $this->assertTrue($predicate->test(4000));
        $this->assertTrue($predicate->test(6_000_000));
        $this->assertTrue($predicate->test(10E7));
        $this->assertTrue($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
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
        $this->assertFalse($predicate->perform(10));
        $this->assertFalse($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate->perform(11));
        $this->assertFalse($predicate->perform(10.0000001));
        $this->assertTrue($predicate->perform(4000));
        $this->assertTrue($predicate->perform(6_000_000));
        $this->assertTrue($predicate->perform(10E7));
        $this->assertTrue($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
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
        $this->assertFalse($predicate(10));
        $this->assertFalse($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate(11));
        $this->assertFalse($predicate(10.0000001));
        $this->assertTrue($predicate(4000));
        $this->assertTrue($predicate(6_000_000));
        $this->assertTrue($predicate(10E7));
        $this->assertTrue($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
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
        $predicate = Predicates::greaterThan(new class implements Countable {
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
        $this->assertFalse($predicate->test(10));
        $this->assertFalse($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate->test(11));
        $this->assertTrue($predicate->test(10.0000001));
        $this->assertTrue($predicate->test(4000));
        $this->assertTrue($predicate->test(6_000_000));
        $this->assertTrue($predicate->test(10E7));
        $this->assertTrue($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
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
        $this->assertFalse($predicate->perform(10));
        $this->assertFalse($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate->perform(11));
        $this->assertTrue($predicate->perform(10.0000001));
        $this->assertTrue($predicate->perform(4000));
        $this->assertTrue($predicate->perform(6_000_000));
        $this->assertTrue($predicate->perform(10E7));
        $this->assertTrue($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
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
        $this->assertFalse($predicate(10));
        $this->assertFalse($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate(11));
        $this->assertTrue($predicate(10.0000001));
        $this->assertTrue($predicate(4000));
        $this->assertTrue($predicate(6_000_000));
        $this->assertTrue($predicate(10E7));
        $this->assertTrue($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
            }
        }));
    }

    /**
     * @return void
     *
     * @test
     */
    public function correctResultFromTestedIntegerFromHelper(): void
    {
        $predicate = Predicates::greaterThan(10);

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
        $this->assertFalse($predicate->test(10));
        $this->assertFalse($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate->test(11));
        $this->assertTrue($predicate->test(10.0000001));
        $this->assertTrue($predicate->test(4000));
        $this->assertTrue($predicate->test(6_000_000));
        $this->assertTrue($predicate->test(10E7));
        $this->assertTrue($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
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
        $this->assertFalse($predicate->perform(10));
        $this->assertFalse($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate->perform(11));
        $this->assertTrue($predicate->perform(10.0000001));
        $this->assertTrue($predicate->perform(4000));
        $this->assertTrue($predicate->perform(6_000_000));
        $this->assertTrue($predicate->perform(10E7));
        $this->assertTrue($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
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
        $this->assertFalse($predicate(10));
        $this->assertFalse($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate(11));
        $this->assertTrue($predicate(10.0000001));
        $this->assertTrue($predicate(4000));
        $this->assertTrue($predicate(6_000_000));
        $this->assertTrue($predicate(10E7));
        $this->assertTrue($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
            }
        }));
    }

    /**
     * @return void
     *
     * @test
     */
    public function correctResultFromTestedFloatFromHelper(): void
    {
        $predicate = Predicates::greaterThan(10.8);

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
        $this->assertFalse($predicate->test(10));
        $this->assertFalse($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate->test(11));
        $this->assertFalse($predicate->test(10.0000001));
        $this->assertTrue($predicate->test(4000));
        $this->assertTrue($predicate->test(6_000_000));
        $this->assertTrue($predicate->test(10E7));
        $this->assertTrue($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
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
        $this->assertFalse($predicate->perform(10));
        $this->assertFalse($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate->perform(11));
        $this->assertFalse($predicate->perform(10.0000001));
        $this->assertTrue($predicate->perform(4000));
        $this->assertTrue($predicate->perform(6_000_000));
        $this->assertTrue($predicate->perform(10E7));
        $this->assertTrue($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
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
        $this->assertFalse($predicate(10));
        $this->assertFalse($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate(11));
        $this->assertFalse($predicate(10.0000001));
        $this->assertTrue($predicate(4000));
        $this->assertTrue($predicate(6_000_000));
        $this->assertTrue($predicate(10E7));
        $this->assertTrue($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
            }
        }));
    }

    /**
     * @return void
     *
     * @test
     */
    public function correctResultFromTestedCountableFromHelper(): void
    {
        $predicate = Predicates::greaterThan(new class implements Countable {
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
        $this->assertFalse($predicate->test(10));
        $this->assertFalse($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate->test(11));
        $this->assertTrue($predicate->test(10.0000001));
        $this->assertTrue($predicate->test(4000));
        $this->assertTrue($predicate->test(6_000_000));
        $this->assertTrue($predicate->test(10E7));
        $this->assertTrue($predicate->test(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
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
        $this->assertFalse($predicate->perform(10));
        $this->assertFalse($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate->perform(11));
        $this->assertTrue($predicate->perform(10.0000001));
        $this->assertTrue($predicate->perform(4000));
        $this->assertTrue($predicate->perform(6_000_000));
        $this->assertTrue($predicate->perform(10E7));
        $this->assertTrue($predicate->perform(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
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
        $this->assertFalse($predicate(10));
        $this->assertFalse($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 9;
            }
        }));
        $this->assertTrue($predicate(11));
        $this->assertTrue($predicate(10.0000001));
        $this->assertTrue($predicate(4000));
        $this->assertTrue($predicate(6_000_000));
        $this->assertTrue($predicate(10E7));
        $this->assertTrue($predicate(new class implements Countable {
            #[Override]
            public function count(): int
            {
                return 11;
            }
        }));
    }
}
