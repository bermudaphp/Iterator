<?php

namespace Bermuda\Iterator;

use Bermuda\Arrayable;

function iterableToArray(iterable $iterable): array
{
    $data = [];
  
    if ($iterable instanceof Arrayable)
    {
        return $iterable->toArray();
    }
    
    elseif (is_array($iterable))
    {
        return $iterable;
    }
    
    foreach($iterable as $k => $v)
    {
        $data[$k] = $v;
    }
    
    return $data;
}
