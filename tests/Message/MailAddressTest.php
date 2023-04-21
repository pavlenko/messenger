<?php

namespace PE\Component\Messenger\Tests\Message;

use PE\Component\Messenger\Exception\InvalidArgumentException;
use PE\Component\Messenger\Message\MailAddress;
use PHPUnit\Framework\TestCase;

final class MailAddressTest extends TestCase
{
    public function testFromStringMalformed()
    {
        $this->expectException(InvalidArgumentException::class);
        MailAddress::fromString('');
    }

    public function testFromString()
    {
        $address = MailAddress::fromString('test@test.com');
        self::assertSame('test@test.com', $address->getEmail());
        self::assertNull($address->getName());

        $address = MailAddress::fromString('Foo <test@test.com>');
        self::assertSame('test@test.com', $address->getEmail());
        self::assertSame('Foo', $address->getName());
    }

    public function testToString()
    {
        self::assertSame('test@test.com', (string) new MailAddress('test@test.com'));
        self::assertSame('Foo <test@test.com>', (string) new MailAddress('test@test.com', 'Foo'));
    }
}