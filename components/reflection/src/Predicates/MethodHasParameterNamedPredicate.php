<?php
declare(strict_types=1);

namespace Smpl\Reflection\Predicates;

use Override;

final class MethodHasParameterNamedPredicate extends BaseMethodPredicate
{
    private string $name;

    private bool   $caseSensitive;

    public function __construct(string $name, bool $caseSensitive = true)
    {
        $this->name = $name;
        $this->caseSensitive = $caseSensitive;
    }

    /**
     * @param \ReflectionMethod $value
     *
     * @return bool
     */
    #[Override]
    public function test(mixed $value): bool
    {
        foreach($value->getParameters() as $parameter) {
            $paramName = $parameter->getName();

            if ($this->caseSensitive) {
                $paramName = strtolower($paramName);
            }

            if ($paramName === $this->name) {
                return true;
            }
        }

        return false;
    }
}
