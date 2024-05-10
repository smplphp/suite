<?php
declare(strict_types=1);

namespace Smpl\Collections\Exceptions;

use OutOfBoundsException;

final class InvalidIndexException extends OutOfBoundsException
{
    public static function outOfRange(int $index, int $min, int $max): self
    {
        return new self(sprintf('The provided index %d it outside of the range of %d-%d', $index, $min, $max));
    }
}
