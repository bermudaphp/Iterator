<?php

namespace Bermuda\Stdlib;

if (!function_exists('Bermuda\Stdlib\to_array')) {
    function to_array(iterable|object $arrayable): array
    {
        if ($arrayable instanceof Arrayable) return $arrayable->toArray();
        if ($arrayable instanceof \IteratorAggregate) return \iterator_to_array($arrayable->getIterator());
        if ($arrayable instanceof \Iterator) return \iterator_to_array($arrayable);
        if (is_array($arrayable)) return $arrayable;

        return \get_object_vars($arrayable);
    }
}

