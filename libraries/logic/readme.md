# SMPL Logic

This library provides a number of interfaces and implementations that encapsulate logical operations.
Generally, they are all one of five types.

## Comparators

### `Smpl\Logic\Contracts\Comparator`

Comparators are classes that compare two values, A and B to determine whether A is less than, equal to, or greater
than B. Their operation is analogous with a mathematical sign (signum) function,
returning less than 0 when less than, 0 when equal to, and greater than 0 when greater than.

By default, all comparators are invertible, allowing you to swap the argument order,
and are considered binary operations, meaning they are invokable and can be used where any other binary
operation can.

A basic implementation
that makes use of the PHP [spaceship operator](https://www.php.net/manual/en/language.operators.comparison.php) is
provided.
There is also an abstract implementation provided
(`Smpl\Logic\Comparators\BaseComparator`) so that you may implement your own.

## Consumers

### `Smpl\Logic\Contracts\Consumer`

Consumers are classes that take a single value, and return nothing.
As the name may suggest, their job is to consume the provided value,
though the individual implementations are responsible for defining what it is to be 'consumed'.

No implementations are provided at this time.

## Operations

### `Smpl\Logic\Contracts\Operation`

Operations are the class/object version of a "function",
and the `Smpl\Logic\Contracts\Operation` contract can be considered a "functional interface",
or at least, as close as we can get to that with PHP.
Operations take a single argument of a type, and return a value of a second type.

There are three abstract implementations provided, one for each core contract
(`Smpl\Logic\Operations\BaseOperation`,
`Smpl\Logic\Operations\BaseUnaryOperation`, and `Smpl\Logic\Operations\BaseBinaryOpertaion`).

On top of that, there are two implementations provided.

#### `Smpl\Logic\Operations\ComposedOperation`

This implementation is that of a composed function, accepted two instances of `Operation`, a before, and an after.
When ran, this implementation will first run the before operation, and then use its return value to run the after
operation, before finally returning the result.

#### `Smpl\Logic\Operations\ProxyOperation`

This implementation is a wrapper for callables, so you can take an anonymous function and turn it into an operation.

### `Smpl\Logic\Contracts\UnaryOperation`

Unary operations are an extension of the default `Operation` contract where the argument and return type are the same.

### `Smpl\Logic\Contracts\BinaryOperation`

Binary operations are alternatives to the default `Operation` where there are instead two arguments,
possibly of the same
or different types, as well as a return type.
Comparators are always binary operations.

## Predicates

### `Smpl\Logic\Contracts\Predicates`

Predicates are the class/object version of "boolean-value functions".
A predicate tests a value against an implementation defined test,
and returns a boolean to signify whether it passed or not.
All predicates are also operations, so are invokable and can be used in place of an operation.

An abstract implementation (`Smpl\Logic\Predicates\BasePredicate`) is provided to simplify the creation of your own.

There are also a number of implementations provided which should cover a number of use-cases.

#### `Smpl\Logic\Predicates\ComposedPredicate`

This implementation is a variation of the `ComposedOperation` class.
Similar to that implementation, this one passes a value to a before `Operation`, and then tests the return value against
a provided after `Predicate`.

#### `Smpl\Logic\Predicates\EqualToPredicate`

This implementation tests a value to see if it is considered equal to a predefined one.
Internally this implementation uses the equality operator (`==`).

#### `Smpl\Logic\Predicates\GreaterThanPredicate`

This implementation tests a value to see if the is greater than a predefined one.

#### `Smpl\Logic\Predicates\LessThanPredicate`

This implementation tests a value to see if it is less than a predefined one.

#### `Smpl\Logic\Predicates\LogicalAndPredicate`

This implementation tests a value against multiple predicates and passes if all do.
This implementation will short-circuit as soon as a predicate fails.

#### `Smpl\Logic\Predicates\LogicalOrPredicate`

This implementation tests a value against multiple predicates, and passes if at least one does.
This implementation will short-circuit as soon as a predicate passes.

#### `Smpl\Logic\Predicates\LogicalXorPredicate`

This implementation tests a value against two predicates, passing if only one of the two predicates passes, and
fails in all other cases.

#### `Smpl\Logic\Predicates\NegatedPredicate`

This implementation reverses the result of any other predicate, turning a pass to a fail and a fail to a pass.

#### `Smpl\Logic\Predicates\NumericallyEqualToPredicate`

This implementation tests a numeric value,
or one that implements the `\Countable` contract, against a predefined numeric value, or implementation of `\Countable`.

#### `Smpl\Logic\Predicates\ProxyPredicate`

This implementation wraps a callable so that it can be treated as a predicate.

#### `Smpl\Logic\Predicates\SameAsPredicate`

This implementation tests a value to see if it is considered the same as a predefined one.
Internally this implementation uses the identicality operation (`===`).

## Suppliers
### `Smpl\Logic\Contracts\Supplier`

Suppliers are classes that take no values, but return one.
The best way to think of them is to consider them lazy wrappers for values, or lazy wrappers for the provider of a value.

There are two implementations provided

#### `Smpl\Logic\Suppliers\LazySupplier`

This implementation takes a callable value that, once requested, will be treated as the provider of the value.
Internally the implementation creates a `ValueSupplier` the first time the value is requested,
and proxies all subsequent requests to the internal `ValueSupplier`.

#### `Smpl\Logic\Suppliers\ValueSupplier`

This implementation wraps a value with no additional logic.
Its existence is purely to allow for a simple way to handle processes that must require a `Supplier`,
but where you already have the value.

## Optional
### `Smpl\Logic\Optional`

This class is a PHP implementation of an optional value.
The class itself can contain a value, `null`, or no value, and be passed or returned where necessary.
It also serves as a nice example of using consumers and suppliers.
