<?php

namespace Bermuda\Iterator;

use ArrayIterator;
use Countable;
use Iterator;
use IteratorAggregate;
use Generator;

/**
 * Class IterableArrayIterator
 *
 * This iterator caches items from an iterable lazily while preserving their original keys.
 * Once an item is encountered, it is stored in the cache so that subsequent iterations or calls
 * (such as toArray() or count()) can use the stored values without re-traversing the original iterable.
 */
final class IterableArrayIterator implements Iterator, Countable
{
    /**
     * Array cache of traversed values.
     *
     * @var array
     */
    private array $traversedArray = [];

    /**
     * Array cache of original keys corresponding to the traversed items.
     *
     * @var array
     */
    private array $traversedKeys = [];

    /**
     * Flag indicating whether the entire iterable has been fully traversed and cached.
     *
     * @var bool
     */
    private(set) bool $traversed = false;

    /**
     * Current position in the iteration over the cached items.
     *
     * @var int
     */
    private(set) int $currentPosition = 0;

    /**
     * Total count of items processed so far.
     *
     * @var int
     */
    private(set) int $count = 0;

    /**
     * Underlying iterator for lazy traversal.
     *
     * @var Iterator|null
     */
    private ?Iterator $iterable = null;

    /**
     * Constructor accepts any iterable.
     *
     * If the iterable is an array, it caches the array immediately (preserving original keys),
     * sets the count accordingly, and marks the iterator as fully traversed.
     *
     * @param iterable $iterable
     */
    public function __construct(iterable $iterable)
    {
        if (is_array($iterable)) {
            $this->traversedArray = $iterable;
            $this->traversedKeys = array_keys($iterable);
            $this->count = count($this->traversedKeys);
            $this->traversed = true;
        } else {
            $this->iterable = $iterable instanceof IteratorAggregate
                ? $iterable->getIterator() : $iterable;

        }
    }

    /**
     * Returns the total number of items.
     *
     * If the iterable has not been fully traversed, toArray() is called to force caching
     * of all items. Then the count is returned.
     *
     * @return int
     */
    public function count(): int
    {
        $this->traversed ?: $this->toArray();
        return $this->count;
    }

    /**
     * Returns the current element.
     *
     * If the iterator has been fully traversed, the value is retrieved from the cached array.
     * Otherwise, if the current position is already cached, it returns that value.
     * If the current position is not cached, it retrieves the current value (and key)
     * from the underlying iterator, caches them, then returns the value.
     *
     * @return mixed
     */
    public function current(): mixed
    {
        if ($this->traversed) {
            $key = $this->traversedKeys[$this->currentPosition] ?? null;
            return $key !== null ? ($this->traversedArray[$key] ?? null) : null;
        }

        if ($this->currentPosition < $this->count) {
            return $this->traversedArray[$this->traversedKeys[$this->currentPosition]];
        }

        $this->count++;

        $this->traversedKeys[] = $key = $this->iterable->key();
        $this->traversedArray[$key] = $this->iterable->current();

        return $this->traversedArray[$key];
    }

    /**
     * Returns the key of the current element.
     *
     * If the iterator has been fully traversed or the key exists in the cache,
     * the original cached key is returned.
     * Otherwise, it returns the key from the underlying iterator.
     *
     * @return mixed
     */
    public function key(): mixed
    {
        if ($this->traversed || $this->currentPosition < $this->count) {
            return $this->traversedKeys[$this->currentPosition];
        }

        return $this->iterable->key();
    }

    /**
     * Moves forward to the next element.
     *
     * Increments the internal position pointer. If not fully traversed and the current
     * position is equal to or greater than the number of cached items, the underlying
     * iterator is advanced.
     *
     * @return void
     */
    public function next(): void
    {
        $this->currentPosition++;
        if (!$this->traversed && $this->currentPosition >= $this->count) {
            $this->iterable->next();
        }
    }

    /**
     * Checks whether the current position is valid.
     *
     * It first checks if the position exists in the cache. If not, it checks whether
     * the underlying iterator is valid. If the underlying iterator is no longer valid,
     * the iterator is marked as fully traversed.
     *
     * @return bool
     */
    public function valid(): bool
    {
        if ($this->traversed) {
            return isset($this->traversedKeys[$this->currentPosition]);
        }

        $result = $this->currentPosition < $this->count || $this->iterable->valid();

        if (!$result) {
            $this->traversed = true;
            $this->iterable = null;
        }

        return $result;
    }

    /**
     * Rewinds the iterator to the first element.
     *
     * If the underlying iterator is not yet fully traversed and is not a Generator,
     * the underlying iterator's rewind method is called. Then, the internal pointer
     * is reset to zero.
     *
     * @return void
     */
    public function rewind(): void
    {
        if (!$this->traversed && !$this->iterable instanceof Generator) {
            $this->iterable->rewind();
        }

        $this->currentPosition = 0;
    }

    /**
     * Forces traversal of the entire underlying iterator and caches all items.
     *
     * This method is used internally (for example, by toArray() and count())
     * to ensure that the full contents of the iterable are cached.
     *
     * @return array The fully cached array of values.
     */
    public function toArray(): array
    {
        if (!$this->traversed) {
            while ($this->valid()) {
                $this->current();
                $this->next();
            }
        }

        return $this->traversedArray;
    }
}