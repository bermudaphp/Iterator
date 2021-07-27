<?php

namespace Bermuda\Iterator;

use Bermuda\Arrayable;

/**
 * Class StringIterator
 * @package Bermuda\Iterator
 */
final class StringIterator implements \Iterator, Arrayable, \Stringable
{
    use IteratorToArray;
   
    private string $subject;
    private int $stringLength;
    
    private int $position = 0;
    
    public function __construct(string $subject) 
    {
        $this->subject = $subject;
        $this->stringLength = mb_strlen($string);
    }
    
    public function __toString(): string
    {
        return $this->getString();
    }
    
    /**
     * @return string
     */
    public function getString(): string
    {
        return $this->subject;
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current() 
    {
        return $this->subject[$this->position];
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next() 
    {
        $this->position++;
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->position;
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
        return $this->position < $this->stringLength;
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind() 
    {
        $this->position = 0;
    }
}
