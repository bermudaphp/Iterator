<?php

declare(strict_types=1);

namespace Bermuda\Stdlib\Tests;

use Bermuda\Stdlib\StringIterator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Bermuda\Stdlib\StringIterator
 */
class StringIteratorTest extends TestCase
{
    public function testConstructor(): void
    {
        $iterator = new StringIterator('abc');
        $this->assertSame('abc', (string) $iterator);
    }

    public function testWithString(): void
    {
        $iterator = new StringIterator('abc');
        $newIterator = $iterator->withString('def');
        
        $this->assertSame('abc', (string) $iterator);
        $this->assertSame('def', (string) $newIterator);
    }

    public function testCurrent(): void
    {
        $iterator = new StringIterator('abc');
        $this->assertSame('a', $iterator->current());
    }

    public function testNext(): void
    {
        $iterator = new StringIterator('abc');
        $iterator->next();
        $this->assertSame('b', $iterator->current());
    }

    public function testKey(): void
    {
        $iterator = new StringIterator('abc');
        $this->assertSame(0, $iterator->key());
        $iterator->next();
        $this->assertSame(1, $iterator->key());
    }

    public function testValid(): void
    {
        $iterator = new StringIterator('abc');
        $this->assertTrue($iterator->valid());
        
        $iterator->next();
        $iterator->next();
        $iterator->next();
        $this->assertFalse($iterator->valid());
    }

    public function testRewind(): void
    {
        $iterator = new StringIterator('abc');
        $iterator->next();
        $iterator->rewind();
        $this->assertSame(0, $iterator->key());
        $this->assertSame('a', $iterator->current());
    }

    public function testIsEnd(): void
    {
        $iterator = new StringIterator('abc');
        $this->assertFalse($iterator->isEnd());
        
        $iterator->next();
        $iterator->next();
        $iterator->next();
        $this->assertTrue($iterator->isEnd());
    }

    public function testIsStart(): void
    {
        $iterator = new StringIterator('abc');
        $this->assertTrue($iterator->isStart());
        
        $iterator->next();
        $this->assertFalse($iterator->isStart());
    }

    public function testMoveTo(): void
    {
        $iterator = new StringIterator('abc');
        $iterator->moveTo(2);
        $this->assertSame(2, $iterator->key());
        $this->assertSame('c', $iterator->current());
    }

    public function testForward(): void
    {
        $iterator = new StringIterator('abc');
        $iterator->forward();
        $this->assertSame(1, $iterator->key());
        $this->assertSame('b', $iterator->current());
    }

    public function testBackward(): void
    {
        $iterator = new StringIterator('abc');
        $iterator->forward(2);
        $iterator->backward();
        $this->assertSame(1, $iterator->key());
        $this->assertSame('b', $iterator->current());
    }

    public function testReadNext(): void
    {
        $iterator = new StringIterator('abc');
        $this->assertSame('abc', $iterator->readNext());
        
        $iterator->next();
        $this->assertSame('bc', $iterator->readNext());
        
        $iterator = new StringIterator('abcdef');
        $this->assertSame('abc', $iterator->readNext(3));
    }

    public function testMultibyteString(): void
    {
        $iterator = new StringIterator('Привет');
        $this->assertSame('П', $iterator->current());
        $iterator->next();
        $this->assertSame('р', $iterator->current());
        
        $iterator->moveTo(2);
        $this->assertSame('и', $iterator->current());
        
        $this->assertSame('ивет', $iterator->readNext());
    }

    public function testEmptyString(): void
    {
        $iterator = new StringIterator('');
        $this->assertFalse($iterator->valid());
        $this->assertNull($iterator->current());
        $this->assertTrue($iterator->isEnd());
        $this->assertTrue($iterator->isStart());
    }

    public function testIteratorAggregate(): void
    {
        $iterator = new StringIterator('abc');
        $chars = [];
        
        foreach ($iterator as $index => $char) {
            $chars[$index] = $char;
        }
        
        $this->assertSame([0 => 'a', 1 => 'b', 2 => 'c'], $chars);
    }
}
