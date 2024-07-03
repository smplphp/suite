<?php

namespace Smpl\DI\Exceptions;

final class BindingAlreadyRegisteredException extends DependencyInjectionException
{
    public static function make(string $class, bool $alias = false): BindingAlreadyRegisteredException
    {
        if ($alias) {
            $message = 'Cannot bind [%s] as an alias, it is already registered';
        } else {
            $message = 'Cannot bind [%s], it is already registered';
        }

        return new self(sprintf($message, $class));
    }
}
