Collection
==========

[![Build Status](https://travis-ci.org/jdecool/collection.svg?branch=master)](https://travis-ci.org/jdecool/collection)
[![Latest Stable Version](https://poser.pugx.org/jdecool/collection/v/stable.png)](https://packagist.org/packages/jdecool/collection)

Provide a fluent collection library.

## Available methods

### all

Get all items of the collection

```php
$collection = new Collection([0, 1, 2, 3]);
$collection->all(); // [0, 1, 2, 3]
```

### contains

Determine if an item exists in the collection

```php
$collection = new Collection([0, 1, 2, 3]);
$collection->contains(1); // true
$collection->contains(5); // false
```

### count

Count the number of items in the collection

```php
$collection = new Collection();
$collection->count(); // 0

$collection = new Collection([0, 1, 2, 3]);
$collection->count(); // 4
```

### diff

Computes the difference of items in the collection

```php
$collection = new Collection(['foo' => 'bar', 'john' => 'doe', 'jane' => 'doe']);
$collection->diff('foo'); // Collection(['foo' => 'bar', 'john' => 'doe', 'jane' => 'doe'])

$collection = new Collection(['foo' => 'bar', 'john' => 'doe', 'jane' => 'doe']);
$collection->diff('doe'); // Collection(['foo' => 'bar'])
```

### diffKeys

Computes the difference of keys in the collection

```php
$collection = new Collection(['foo' => 'bar', 'john' => 'doe', 'jane' => 'doe']);
$collection->diffKeys('foo'); // Collection(['foo' => 'bar', 'john' => 'doe', 'jane' => 'doe'])

$collection = new Collection(['foo' => 'bar', 'john' => 'doe', 'jane' => 'doe']);
$collection->diffKeys('foo' => 'bar'); // Collection(['john' => 'doe', 'jane' => 'doe'])
```

### filter

Filter the collection

```php
$collection = new Collection(['foo' => 'bar', 'john' => 'doe', 'test' => 'bar']);
$collection->filter(function($item) {
    return $item === 'bar';
}); // Collection(['foo' => 'bar', 'test' => 'bar'])
```

### first

Search first element

```php
$collection = new Collection([
    ['a' => '1', 'foo' => 'a'], 
    ['a' => '2', 'foo' => 'b'], 
    ['a' => '3', 'foo' => 'c'], 
    ['a' => '4', 'foo' => 'b'],
]);

$collection->first(); // ['a' => '1', 'foo' => 'a']

$collection->first(function($item) {
    return $item['foo'] === 'b';
}); // ['a' => '2', 'foo' => 'b']

$collection->first(/* ... */, 'default value if not found')
```

### flip

Exchanges all keys with their associated values in an array

```php
$collection = new Collection(['foo' => 'bar', 'john' => 'doe']);
$collection->flip(); // Collection(['bar' => 'foo', 'doe' => 'john'])
```

### get

Get an item from the collection

```php
$collection = new Collection(['foo' => 'bar', 'john' => 'doe']);
$collection->get('foo'); // 'bar'
$collection->get('bar'); // null
$collection->get('bar', 'myDefaultValue'); // 'myDefaultValue'
```

### has

Determine if a key exists in the collection

```php
$collection = new Collection(['foo' => 'bar', 'john' => 'doe']);
$collection->has('foo'); // true
$collection->has('bar'); // false
```

### isEmpty

Check if the collection is empty

```php
$collection = new Collection(['foo' => 'bar', 'john' => 'doe']);
$collection->isEmpty(); // false
```

### keys

Get all keys of the collection

```php
$collection = new Collection(['foo' => 'bar', 'john' => 'doe']);
$collection->keys(); // Collection(['foo', 'john'])
```

### last

Search last element

```php
$collection = new Collection([
    ['a' => '1', 'foo' => 'a'], 
    ['a' => '2', 'foo' => 'b'], 
    ['a' => '4', 'foo' => 'b'],
    ['a' => '3', 'foo' => 'c'], 
]);

$collection->last(); // ['a' => '3', 'foo' => 'c']

$collection->last(function($item) {
    return $item['foo'] === 'b';
}); // ['a' => '4', 'foo' => 'b']

$collection->last(/* ... */, 'default value if not found')
```

### map

Applies the callback to the elements of the given arrays

```php
$collection = new Collection([0, 1, 2, 3]);
$collection->map(function($item) {
    return $item + 10;
}); // Collection([10, 11, 12, 13])
```

### reduce

Reduce the array to a single value

```php
function sum($carray, $item)
{
    return $carray + $item;
}

$collection = new Collection([0, 1, 2, 3]);
$collection->reduce('sum'); // 6

$collection = new Collection([
    [
        'note'  => 5,
        'coeff' => 1,
    ],
    [
        'note'  => 8,
        'coeff' => 2,
    ],
]);
$collection->reduce(function ($carry, $item) {
    return $carry + $item['note'];
}); // 13
```

### reject

Create a collection without elements

```php
$collection = new Collection([0, 1, 2, 3]);
$collection->reject(function($item) {
    return $item === 1;
}); // Collection([0, 2, 3])

$collection = new Collection(['foo' => 'bar', 'john' => 'doe', 'test' => 'bar']);
$collection->reject(function($item) {
    return $item === 'bar';
}); // Collection(['john' => 'doe'])
```
