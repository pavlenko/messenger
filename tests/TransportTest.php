<?php

namespace PE\Component\Messenger\Tests;

use PE\Component\Messenger\Message\MessageInterface;
use PE\Component\Messenger\TransportBase;
use PHPUnit\Framework\TestCase;

final class TransportTest extends TestCase
{
    public function testGetName()
    {
        self::assertSame('FooTransport', (new FooTransport())->getName());
    }
}

final class FooTransport extends TransportBase
{
    public function send(MessageInterface ...$message): void
    {
        // Do nothing
    }
}