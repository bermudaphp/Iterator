<?php

namespace Bermuda\Iterator;

use Bermuda\String\Stringable;
use Psr\Http\Message\StreamInterface;

/**
 * Class StreamIterator
 * @package Bermuda\Iterator
 */
final class StreamIterator implements \Iterator, Stringable
{
    private int $bytesPerIteration;
    private StreamInterface $stream;

    public function __construct(StreamInterface $stream, int $bytesPerIteration = 1024)
    {
        $this->stream = $stream;
        $this->bytesPerIteration = $bytesPerIteration;
    }

    public function __toString(): string
    {
        return $this->stream->getContents();
    }

    public function getStream(): StreamInterface
    {
        return clone $this->stream;
    }

    public function withStream(StreamInterface $stream): self
    {
        $copy = clone $this;
        $this->stream = $stream;

        return $copy;
    }

    public function current()
    {
        return $this->stream->read($this->bytesPerIteration);
    }

    public function next(): void
    {
    }

    public function key(): int
    {
        return $this->stream->tell();
    }

    public function valid(): bool
    {
        return $this->stream->eof() !== true;
    }

    public function rewind()
    {
        if (!$this->stream->isReadable())
        {
            throw new \RuntimeException('Stream is not readable');
        }

        $this->stream->rewind();
    }
}
