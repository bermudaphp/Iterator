<?php

namespace Bermuda\Iterator;

use Bermuda\String\Stringable;
use Psr\Http\Message\StreamInterface;

final class StreamIterator implements \Iterator, Stringable
{
    private int $bytesPerIteration;
    private StreamInterface $stream;

    public function __construct(StreamInterface $stream, int $bytesPerIteration = 1024)
    {
        if (!$stream->isReadable()) {
            throw new \RuntimeException('Stream is not readable');
        }
        
        $this->setBytes($bytesPerIteration)->stream = $stream;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->stream;
    }
    
    /**
     * @param int $bytes
     * @return StreamIterator
     */
    public function setBytes(int $bytes): self
    {
        $this->bytesPerIteration = $bytes;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getBytes(): int
    {
        return $this->bytesPerIteration;
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
        $copy->stream = $stream;

        return $copy;
    }

    /**
     * @inheritDoc
     */
    public function current(): mixed
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
    public function rewind(): void
    {
        $this->stream->rewind();
    }
}
