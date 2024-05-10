<?php
declare(strict_types=1);

namespace Smpl\Logic\Exceptions;

use LogicException;

final class OptionalException extends LogicException
{
    public static function noValue(): self
    {
        return new self('The optional has no value');
    }

    /**
     * @return self
     *
     * @infection-ignore-all
     * @codeCoverageIgnore
     */
    public static function tooManyParameters(): self
    {
        return new self('Optionals can only be created with a single parameter');
    }
}
