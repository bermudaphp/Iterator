<?php

namespace Bermuda\Iterator;

/**
 * Class FilterIterator
 * @package Bermuda\Iterator
 */
class FilterIterator extends Iterator 
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * FilterIterator constructor.
     * @param iterable $data
     * @param callable $callback
     */
    public function __construct(iterable $data, callable $callback)
    {
        parent::__construct($data);
        $this->setCallback($callback);
    }

    /**
     * @param callable $callback
     * @return FilterIterator
     */
    public function setCallback(callable $callback): self 
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }

    /**
     * @return bool
     */
    protected function accept(): bool 
    {
        return (bool) ($this->callback)($this->current(), $this->key());
    }

    /**
     * @return bool
     */
    public function valid(): bool 
    {
        if (parent::valid())
        {
            if ($this->accept())
            {
                return true;
            }

            $this->next();

            return $this->valid();
        }

        return false;
    }
}
