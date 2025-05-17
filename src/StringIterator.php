<?php

declare(strict_types=1);

namespace Bermuda\Stdlib;

/**
 * Iterator for strings that supports character-by-character iteration
 */
final class StringIterator implements \Iterator, \Stringable
{
    /**
     * Length of the string in characters
     */
    private(set) int $length;

    /**
     * Current position in the string
     */
    private(set) int $position = 0;

    /**
     * Create a new string iterator
     *
     * @param string $string The string to iterate over
     */
    public function __construct(
        /**
         * The string being iterated
         */
        private(set) readonly string $string,
    ) {
        $this->length = mb_strlen($this->string);
    }

    /**
     * Get string representation
     *
     * @return string The string being iterated
     */
    public function __toString(): string
    {
        return $this->string;
    }

    /**
     * Create a new iterator with a different string
     *
     * @param string $string New string to iterate
     * @return self New iterator instance
     */
    public function withString(string $string): self
    {
        return new self($string);
    }

    /**
     * Get the current character
     *
     * @return string|null Current character or null if position is invalid
     */
    public function current(): ?string
    {
        if (!$this->valid()) {
            return null;
        }

        return $this->string[$this->position];
    }

    /**
     * Move to the next character
     *
     * @return void
     */
    public function next(): void
    {
        $this->position++;
    }

    /**
     * Get the current position
     *
     * @return int Current position
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * Check if the current position is valid
     *
     * @return bool True if the current position is valid
     */
    public function valid(): bool
    {
        return $this->position >= 0 && $this->position < $this->length;
    }

    /**
     * Reset the iterator to the beginning
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->position = 0;
    }


    /**
     * Check if the iterator is at the end of the string
     *
     * @return bool True if the iterator has reached the end
     */
    public function isEnd(): bool
    {
        return $this->position >= $this->length;
    }

    /**
     * Check if the iterator is at the beginning of the string
     *
     * @return bool True if the iterator is at the beginning
     */
    public function isStart(): bool
    {
        return $this->position <= 0;
    }

    /**
     * Move to a specific position
     *
     * @param int $position New position
     * @return self
     * @throws \OutOfRangeException If position is invalid
     */
    public function moveTo(int $position): self
    {
        if ($position < 0 || $position >= $this->length) {
            throw new \OutOfRangeException("Invalid position: {$position}");
        }

        $this->position = $position;
        return $this;
    }

    /**
     * Move forward by a number of characters
     *
     * @param int $steps Number of characters to move forward
     * @return self
     */
    public function forward(int $steps = 1): self
    {
        $newPosition = min($this->position + $steps, $this->length);
        return $this->moveTo($newPosition);
    }

    /**
     * Move backward by a number of characters
     *
     * @param int $steps Number of characters to move backward
     * @return self
     */
    public function backward(int $steps = 1): self
    {
        $newPosition = max($this->position - $steps, 0);
        return $this->moveTo($newPosition);
    }

    /**
     * Get a substring from the current position to the specified length
     *
     * @param int|null $length Number of characters to get or null for rest of string
     * @return string Substring from current position
     */
    public function readNext(?int $length = null): string
    {
        if ($this->isEnd()) {
            return '';
        }

        if ($length === null) {
            $length = $this->length - $this->position;
        }

        return mb_substr($this->string, $this->position, $length);
    }
}
