<?php


namespace Bermuda\Iterator;


/**
 * Class Iterator
 * @package Bermuda\Iterator
 */
class Iterator implements \Iterator 
{
    private \Iterator $iterator;

    public function __construct(iterable $iterable)
    {
        if(is_array($iterable))
        {
            $iterable = new \ArrayIterator($iterable);
        }

        elseif($iterable instanceof \IteratorAggregate)
        {
            $iterable = $iterable->getIterator();
        }

        $this->iterator = $iterable;
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->iterator->current();
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        return $this->iterator->next();
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->iterator->key();
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->iterator->valid();
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->iterator->rewind();
    }
}
