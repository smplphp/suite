<?php
declare(strict_types=1);

namespace Smpl\Logic\Exceptions;

use LogicException;

final class OperationException extends LogicException
{
    public static function recursive(): self
    {
        return new self('You cannot wrap an operation in an operation');
    }
}
