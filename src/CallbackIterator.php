<?php


namespace Lobster\Iterators;


/**
 * Class CallbackIterator
 * @package Lobster\Iterators
 */
class CallbackIterator extends Iterator {

    /**
     * @var callable
     */
    private $callback;

    /**
     * CallbackIterator constructor.
     * @param iterable $iterable
     * @param callable $callback
     */
    public function __construct(iterable $iterable, callable $callback) {
        parent::__construct($iterable);
        $this->callback = $callback;
    }

    /**
     * @return callable
     */
    public function getCallback(): callable {
        return $this->callback;
    }

    /**
     * @return mixed
     */
    public function current() {
        return ($this->callback)(parent::current());
    }
}
