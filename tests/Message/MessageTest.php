<?php

namespace PE\Component\Messenger\Tests\Message;

use PE\Component\Messenger\DSN;
use PE\Component\Messenger\Event;
use PE\Component\Messenger\Exception\InvalidArgumentException;
use PE\Component\Messenger\Message\MessageBase;
use PE\Component\Messenger\Message\MessageInterface;
use PHPUnit\Framework\TestCase;

final class MessageTest extends TestCase
{
    public function testRecipientInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->getMockForAbstractClass(MessageBase::class, ['ID', 'subject', true]);
    }

    public function testSenderInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->getMockForAbstractClass(MessageBase::class, ['ID', 'subject', 'recipient', true]);
    }

    public function testConstructor()
    {
        $message = $this->getMockForAbstractClass(MessageBase::class, ['ID', 'subject', 'recipient', 'sender']);
        $message->method('getRecipient')->willReturnCallback(\Closure::bind(fn() => $this->recipient, $message, $message));
        $message->method('getSender')->willReturnCallback(\Closure::bind(fn() => $this->sender, $message, $message));

        self::assertSame('ID', $message->getQueueID());
        self::assertSame('subject', $message->getSubject());
        self::assertSame('recipient', $message->getRecipient());
        self::assertSame('sender', $message->getSender());
        self::assertSame(MessageInterface::RESULT_PENDING, $message->getResult());

        self::assertNull($message->getTag());
        $message->setTag('tag');
        self::assertSame('tag', $message->getTag());

        self::assertNull($message->getDSN());
        $message->setDSN($dsn = new DSN('mail', 'host'));
        self::assertSame($dsn, $message->getDSN());
    }

    public function testSetSuccess()
    {
        $message = $this->getMockForAbstractClass(MessageBase::class, ['ID', 'subject', 'recipient', 'sender']);
        $message->setSuccess('messageID');

        self::assertSame(MessageInterface::RESULT_SUCCESS, $message->getResult());
        self::assertSame('messageID', $message->getMessageID());
    }

    public function testSetFailure()
    {
        $message = $this->getMockForAbstractClass(MessageBase::class, ['ID', 'subject', 'recipient', 'sender']);
        $message->setFailure($exception = new \Exception());

        self::assertSame(MessageInterface::RESULT_FAILURE, $message->getResult());
        self::assertSame($exception, $message->getException());
    }

    public function testToEvent()
    {
        $message = $this->getMockForAbstractClass(MessageBase::class, ['ID', 'subject', 'recipient', 'sender']);

        self::assertSame(Event::SENT_FAILURE, $message->toEvent()->getType());

        $message->setSuccess('ID');
        $event = $message->toEvent();

        self::assertSame(Event::SENT_SUCCESS, $event->getType());
        self::assertSame('ID', $event->getExternalMessageID());
        self::assertNull($event->getInternalMessageID());

        $message->setFailure(new \Exception());
        $event = $message->toEvent();

        self::assertSame(Event::SENT_FAILURE, $event->getType());
        self::assertSame('ID', $event->getInternalMessageID());
        self::assertNull($event->getExternalMessageID());
    }
}