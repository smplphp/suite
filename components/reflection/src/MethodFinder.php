<?php
/** @noinspection PhpUnnecessaryStaticReferenceInspection */
declare(strict_types=1);

namespace Smpl\Reflection;

use Smpl\Collections\Dictionary;
use Smpl\Logic\Contracts\Predicate;
use Smpl\Logic\Predicates;
use Smpl\Reflection\Predicates\MethodIsPrivatePredicate;
use Smpl\Reflection\Predicates\MethodIsProtectedPredicate;
use Smpl\Reflection\Predicates\MethodIsPublicPredicate;

/**
 *
 */
final class MethodFinder
{
    private ?Predicate $visibilityPredicate = null;

    private ?Predicate $staticPredicate = null;

    private ?Predicate $abstractPredicate = null;

    private ?Predicate $finalPredicate = null;

    /**
     * @var \Smpl\Collections\Dictionary<string, \ReflectionMethod>
     */
    private Dictionary $results;

    private function findResults(): void
    {
        $methods = [];

        $predicates = $this->gatherPredicates();
        $predicate  = null;

        if (! empty($predicates)) {
            $predicate = Predicates::and(...$predicates);
        }

        /** @var \ReflectionClass $class */
        foreach ($this->getClasses() as $class) {
            foreach ($class->getMethods() as $method) {
                if ($predicate === null) {
                    $methods[$method->getName()] = $method;
                    continue;
                }

                if ($predicate->test($method)) {
                    $methods[$method->getName()] = $method;
                }
            }
        }

        $this->results = new Dictionary($methods);
    }

    /**
     * @return array<int, \Smpl\Logic\Contracts\Predicate<\ReflectionMethod>>
     *
     * @psalm-suppress MixedReturnTypeCoercion
     */
    private function gatherPredicates(): array
    {
        $predicates = [
            $this->visibilityPredicate,
            $this->staticPredicate,
            $this->abstractPredicate,
            $this->finalPredicate,
        ];

        return array_filter($predicates);
    }

    public function visibility(bool $public = true, bool $protected = true, bool $private = true): static
    {
        if ($public === true && $protected === true && $private === true) {
            $this->visibilityPredicate = null;
        } else {
            $predicates = [];

            if ($public) {
                $predicates[] = MethodIsPublicPredicate::instance();
            }

            if ($protected) {
                $predicates[] = MethodIsProtectedPredicate::instance();
            }

            if ($private) {
                $predicates[] = MethodIsPrivatePredicate::instance();
            }

            if (! empty($predicates)) {
                $this->visibilityPredicate = Predicates::or(...$predicates);
            }
        }

        return $this;
    }

    public function public(): static
    {
        $this->visibilityPredicate = MethodIsPublicPredicate::instance();

        return $this;
    }

    public function protected(): static
    {
        $this->visibilityPredicate = MethodIsProtectedPredicate::instance();

        return $this;
    }

    public function private(): static
    {
        $this->visibilityPredicate = MethodIsPrivatePredicate::instance();

        return $this;
    }

    /**
     * @return \Smpl\Collections\Dictionary<string, \ReflectionMethod>
     */
    public function getResults(): Dictionary
    {
        /** @psalm-suppress RedundantPropertyInitializationCheck */
        if (! isset($this->results)) {
            $this->findResults();
        }

        return $this->results;
    }
}
