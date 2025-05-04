<?php

namespace Bermuda\Stdlib;

trait IteratorToArray
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        return iterator_to_array($this);
    }
}
