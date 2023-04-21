<?php

namespace PE\Component\Messenger\Tests;

use PE\Component\Messenger\DSN;
use PE\Component\Messenger\Exception\InvalidArgumentException;
use PE\Component\Messenger\Exception\RuntimeException;
use PHPUnit\Framework\TestCase;

final class DSNTest extends TestCase
{
    public function testFromStringMalformedURL()
    {
        $this->expectException(InvalidArgumentException::class);
        DSN::fromString('////');
    }

    public function testFromStringMissingParts()
    {
        $this->expectException(InvalidArgumentException::class);
        DSN::fromString('foo.com?a=b');
    }

    public function testFromString()
    {
        $dsn = DSN::fromString('mail://user:pass@host:8888?a=b');

        self::assertSame('mail', $dsn->getScheme());
        self::assertSame('host', $dsn->getHost());
        self::assertSame(8888, $dsn->getPort());
        self::assertSame('user', $dsn->getUser());
        self::assertSame('pass', $dsn->getPass());
        self::assertSame('b', $dsn->getOption('a'));
    }

    public function testToString()
    {
        self::assertSame('mail://host', (string) new DSN('mail', 'host'));
        self::assertSame('mail://user@host', (string) new DSN('mail', 'host', 'user'));
        self::assertSame('mail://user:pass@host', (string) new DSN('mail', 'host', 'user', 'pass'));
        self::assertSame('mail://user:pass@host:4444', (string) new DSN('mail', 'host', 'user', 'pass', 4444));
        self::assertSame(
            'mail://user:pass@host:4444?a=b',
            (string) new DSN('mail', 'host', 'user', 'pass', 4444, ['a' => 'b'])
        );
    }

    public function testGetUserRequired()
    {
        $this->expectException(RuntimeException::class);
        DSN::fromString('mail://host')->getUser(true);
    }

    public function testGetPassRequired()
    {
        $this->expectException(RuntimeException::class);
        DSN::fromString('mail://host')->getPass(true);
    }
}