<?php


namespace Lobster\Iterators;


/**
 * Class StringIterator
 * @package Lobster\Iterators
 */
class StringIterator implements \Iterator {

    /**
     * @var string
     */
    private $string;

    /**
     * @var int
     */
    private $len;

    /**
     * @var int
     */
    private $pos = 0;


    /**
     * StringIterator constructor.
     * @param string $string
     */
    public function __construct(string $string) {
        $this->string = $string;
        $this->len = mb_strlen($string);
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current() {
        return $this->string[$this->pos];
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next() {
        $this->pos++;
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key() {
        return $this->pos;
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid() {
        return $this->pos <= $this->len;
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind() {
        $this->pos = 0;
    }
}
