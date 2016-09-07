Collection
==========

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
