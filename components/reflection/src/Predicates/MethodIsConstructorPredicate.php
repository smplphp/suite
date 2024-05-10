<?php
declare(strict_types=1);

namespace Smpl\Reflection\Predicates;

use Override;

final class MethodIsConstructorPredicate extends BaseMethodPredicate
{
    private static self $instance;

    public static function instance(): self
    {
        /** @psalm-suppress RedundantPropertyInitializationCheck */
        if (! isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * @param \ReflectionMethod $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        return $value->isConstructor();
    }
}
