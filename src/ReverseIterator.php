<?php


namespace Lobster\Iterators;


/**
 * Class ReverseIterator
 * @package Lobster\Iterators
 */
class ReverseIterator implements \Iterator {

    /**
     * @var array
     */
    private $data = [];

    /**
     * ReverseIterator constructor.
     * @param iterable $iterable
     */
    public function __construct(iterable $iterable) {

        if($iterable instanceof \IteratorAggregate){
            $iterable = $iterable->getIterator();
        }

        if($iterable instanceof \Iterator){
            $iterable = iterator_to_array($iterable);
        }

        $this->data = $iterable;
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current() {
        return current($this->data);
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next() {
        return prev($this->data);
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key() {
        return key($this->data);
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid() {
        return ($key = $this->key()) !== null && $key !== false;
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind() {
        end($this->data);
    }
}
