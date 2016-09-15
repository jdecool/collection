<?php

namespace JDecool\Collection;

use JsonSerializable;
use Traversable;

class Collection implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /** @var array */
    private $items;

    /**
     * Collection constructor
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        $this->items = $this->getArrayableItems($items);
    }

    /**
     * Get all items of the collection
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Get all keys of the collection
     *
     * @return Collection
     */
    public function keys()
    {
        $keys = array_keys($this->items);

        return new static($keys);
    }

    /**
     * Applies the callback to the elements of the given arrays
     *
     * @param callable $callback
     * @return Collection
     */
    public function map(callable $callback)
    {
        $items = array_map($callback, $this->items);

        return new static($items);
    }

    /**
     * Determine if an item exists in the collection
     *
     * @param mixed $value
     * @return bool
     */
    public function contains($value)
    {
        return in_array($value, $this->items);
    }

    /**
     * Determine if a key exists in the collection
     *
     * @param mixed $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->items[$key]);
    }

    /**
     * Check if the collection is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * Filter the collection
     *
     * @param callable $callback
     * @return Collection
     */
    public function filter(callable $callback)
    {
        $items = array_filter($this->items, $callback);

        return new static($items);
    }

    /**
     * Search first element
     *
     * @param callable|null $callback
     * @param mixed         $default
     * @return mixed
     */
    public function first(callable $callback = null, $default = null)
    {
        if (null === $callback) {
            return reset($this->items);
        }

        return $this->searchFirst($this->items, $callback, $default);
    }

    /**
     * Search last element
     *
     * @param callable|null $callback
     * @param mixed         $default
     * @return mixed
     */
    public function last(callable $callback = null, $default = null)
    {
        if (null === $callback) {
            return end($this->items);
        }

        $items = array_reverse($this->items, true);

        return $this->searchFirst($items, $callback, $default);
    }

    /**
     * Exchanges all keys with their associated values in an array
     *
     * @return Collection
     */
    public function flip()
    {
        $items = array_flip($this->items);

        return new static($items);
    }

    /**
     * Get an item from the collection
     *
     * @param mixed $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        }

        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (null === $offset) {
            $this->items = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * Convert $items parameter into an items array
     *
     * @param mixed $items
     * @return array
     */
    private function getArrayableItems($items)
    {
        if (is_array($items)) {
            return $items;
        } elseif ($items instanceof self) {
            return $items->all();
        } elseif ($items instanceof JsonSerializable) {
            return $items->jsonSerialize();
        } elseif ($items instanceof Traversable) {
            return iterator_to_array($items);
        }

        return (array) $items;
    }

    /**
     * Search first element corresponding to callback
     *
     * @param array    $items
     * @param callable $callback
     * @param mixed    $default
     * @return mixed
     */
    private function searchFirst(array $items, callable $callback, $default = null)
    {
        foreach ($items as $item) {
            if ($callback($item)) {
                return $item;
            }
        }

        return $default;
    }
}
