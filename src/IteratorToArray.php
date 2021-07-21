<?php

namespace Bermuda\Iterator;

trait IteratorToArray
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        $items = [];
        
        foreach ($this as $i => $item)
        {
            $items[$i] = $item;
        }
        
        return $items;
    }
}
