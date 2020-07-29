<?php

declare(strict_types=1);

namespace Recruitment\Utilities\Collection;

use Closure;
use function array_filter;
use function array_key_exists;
use function array_splice;
use function array_values;
use function count;
/**
 * Class that behaves like an array with useful methods.
 */
class ArrayCollection
{
    /**
     * Elements of collection.
     *
     * @var array
     */
    private $elements;

    /**
     * @param array $elements Elements of collection
     */
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    /**
     * Count elements in collection
     * 
     * @return int Quantity of elements in collection
     */
    public function count(): int
    {
        return count($this->elements);
    }

    /**
     * Add new element at the end of array.
     * 
     * @param $element
     */
    public function add($element): self
    {
        $this->elements[] = $element;

        return $this;
    }

    /**
     * Add new or update exists element in array.
     *
     * @param string|int $key   Key of element 
     * @param            $value Value of element
     */
    public function set($key, $value): self
    {
        $this->elements[$key] = $value;

        return $this;
    }

    /**
     * Get element by key
     *
     * @param string|int $key
     *
     * @return Element if exists
     */
    public function get($key)
    {
        if (array_key_exists($key, $this->elements)) {
            $element = $this->elements[$key];
        }

        return $element ?? null;
    }
    /**
     * Return all the elements that met conditions in Closure
     *
     * @param Closure $closure
     * @param         $optionalData Optional data for Closure
     *
     * @return array Array of elements
     */
    public function filter(Closure $closure, $optionalData): array
    {
        $correctElements = [];
        foreach ($this->elements as $element) {
            if ($closure($element, $optionalData)) {
                $correctElements[] = $element;
            }
        }

        return $correctElements;
    }

    /**
     * Remove element from ArrayCollection
     * 
     * @param  sstring|int $key Key of element
     */
    public function remove($key): self
    {
        if (array_key_exists($key, $this->elements)) {
            unset($this->elements[$key]);
            $this->elements = array_values($this->elements);
        }

        return $this;
    }

    /**
     * Remove all elements from $this-elements
     */
    public function clear(): self
    {
        $this->elements = [];

        return $this;
    }

    /**
     * Return elements of ArrayCollection as array
     * 
     * @return array $this->elements;
     */
    public function toArray(): array
    {
        return $this->elements;
    }
}