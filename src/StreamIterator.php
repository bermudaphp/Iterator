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
        if (!$this->stream->isReadable())
        {
            throw new \RuntimeException('Stream is not readable');
        }
        
        $this->stream = $stream;
        $this->bytesPerIteration = $bytesPerIteration;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->stream->getContents();
    }

    /**
     * @return StreamInterface
     */
    public function getStream(): StreamInterface
    {
        return $this->stream;
    }

    /**
     * @param StreamInterface $stream
     * @return StreamIterator
     */
    public function withStream(StreamInterface $stream): self
    {
        $copy = clone $this;
        $this->stream = $stream;

        return $copy;
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->stream->read($this->bytesPerIteration);
    }

    /**
     * @inheritDoc
     */
    public function next(): void {}

    /**
     * @inheritDoc
     */
    public function key(): int
    {
        return $this->stream->tell();
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return $this->stream->eof() !== true;
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->stream->rewind();
    }
}
