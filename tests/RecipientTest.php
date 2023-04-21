<?php

namespace PE\Component\Messenger\Tests;

use PE\Component\Messenger\Exception\RuntimeException;
use PE\Component\Messenger\Recipient;
use PHPUnit\Framework\TestCase;

final class RecipientTest extends TestCase
{
    public function testConstructor()
    {
        $recipient = new Recipient('ID', ['a' => 'b'], []);
        self::assertSame('ID', $recipient->getInternalID());
        self::assertSame(['a' => 'b'], $recipient->getVars());
    }

    public function testGetChatIdentityNotSet()
    {
        $this->expectException(RuntimeException::class);
        (new Recipient('ID', [], []))->getChatIdentity('foo');
    }

    public function testGetChatIdentity()
    {
        self::assertSame('bar', (new Recipient('ID', [], ['foo' => 'bar']))->getChatIdentity('foo'));
    }

    public function testGetEmailIdentityNotSet()
    {
        $this->expectException(RuntimeException::class);
        (new Recipient('ID', [], []))->getEmailIdentity();
    }

    public function testGetEmailIdentity()
    {
        self::assertSame('bar', (new Recipient('ID', [], ['email' => 'bar']))->getEmailIdentity());
    }

    public function testGetPhoneIdentityNotSet()
    {
        $this->expectException(RuntimeException::class);
        (new Recipient('ID', [], []))->getPhoneIdentity();
    }

    public function testGetPhoneIdentity()
    {
        self::assertSame('bar', (new Recipient('ID', [], ['phone' => 'bar']))->getPhoneIdentity());
    }

    public function testGetPushIdentityNotSet()
    {
        $this->expectException(RuntimeException::class);
        (new Recipient('ID', [], []))->getPushIdentity('foo');
    }

    public function testGetPushIdentity()
    {
        self::assertSame('bar', (new Recipient('ID', [], ['foo' => 'bar']))->getPushIdentity('foo'));
    }
}