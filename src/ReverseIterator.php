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
     * @var iterable
     */
    private $iterabele;

    /**
     * ReverseIterator constructor.
     * @param iterable $iterable
     */
    public function __construct(iterable $iterable) {
        $this->iterable = $iterable;
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
        
        if($this->iterbale != null){
            
            if($this->iterable instanceof \IteratorAggregate){
                $this->data = $this->iterable->getIterator();
            }
            
            elseif($this->iterable instanceof \Iterator){
                $this->data = iterator_to_array($this->iterable);
            }
            
            else {
                $this->data = $this->iterable;
            }
            
            $this->iterable = null;
        }
         
        end($this->data);
    }
}
