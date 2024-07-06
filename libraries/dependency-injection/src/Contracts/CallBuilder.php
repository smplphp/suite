<?php

namespace Smpl\DI\Contracts;

/**
 * @template ReturnType of mixed
 */
interface CallBuilder
{
    /**
     * Create a new caller
     *
     * This method creates a new caller for a function/method.
     * The <code>$target</code> parameter should be the name of a function/method,
     * an instance of {@see \Closure}, on an invokable instance.
     *
     * @template CallReturnType of mixed
     *
     * @param string|callable(): CallReturnType $target
     *
     * @return static
     */
    public static function call(string|callable $target): static;

    /**
     * Set the scope of the call
     *
     * This method sets the scope to be used when calling the function/method.
     * If the call is for a method, this should be the class or an instance of
     * the class that method belongs to.
     *
     * @param class-string|object $scope
     *
     * @return static
     */
    public function on(string|object $scope): static;

    /**
     * Set the argument for the call
     *
     * This method sets the arguments to be used when calling the
     * function/method.
     * If the <code>$append</code> parameter is <code>false</code>, any
     * current arguments will be overwritten by those provided, and if it's
     * <code>true</code>, the values will be appended.
     *
     * The argument keys should be the name of the argument, or the position.
     *
     * When the function/method is called, named arguments take precedence over
     * positioned.
     *
     * @param array<string|int, mixed> $arguments
     * @param bool                     $append
     *
     * @return static
     *
     * @see self::with()
     */
    public function using(array $arguments, bool $append = false): static;

    /**
     * Set an argument for the cal
     *
     * This method sets an argument to be used when calling the
     * function/method.
     * This method should always override an argument if one already exists.
     *
     * The <code>$argument</code> parameter should be the name of the argument,
     * or its position.
     *
     * When the function/method is called, named arguments take precedence over
     * positioned.
     *
     * @param string|int $argument
     * @param mixed      $value
     *
     * @return static
     *
     * @see self::using()
     */
    public function with(string|int $argument, mixed $value): static;

    /**
     * Perform the method call
     *
     * This method calls the function/method and returns the result.
     *
     * @return ReturnType
     */
    public function invoke(): mixed;
}
