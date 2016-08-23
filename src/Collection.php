<?php

namespace JDecool\Collection;

use JsonSerializable;
use Traversable;

class Collection
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
}