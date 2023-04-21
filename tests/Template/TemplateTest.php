<?php

namespace PE\Component\Messenger\Tests\Template;

use PE\Component\Messenger\Exception\LogicException;
use PE\Component\Messenger\Message\ChatMessage;
use PE\Component\Messenger\Message\MailAttachment;
use PE\Component\Messenger\Message\MailMessage;
use PE\Component\Messenger\Message\PushMessage;
use PE\Component\Messenger\Message\SMSMessage;
use PE\Component\Messenger\RecipientInterface;
use PE\Component\Messenger\SenderInterface;
use PE\Component\Messenger\Template\ChatTemplate;
use PE\Component\Messenger\Template\MailTemplate;
use PE\Component\Messenger\Template\PushTemplate;
use PE\Component\Messenger\Template\SMSTemplate;
use PHPUnit\Framework\TestCase;

final class TemplateTest extends TestCase
{
    public function testChatTemplate()
    {
        $recipient = $this->createMock(RecipientInterface::class);
        $recipient->expects(self::once())->method('getInternalID');
        $recipient->expects(self::once())->method('getChatIdentity');
        $recipient->expects(self::once())->method('getVars');

        $template = new ChatTemplate('subject', []);
        $message  = $template->compile('foo', $recipient);

        self::assertInstanceOf(ChatMessage::class, $message);
    }

    public function testMailTemplateSenderRequired()
    {
        $this->expectException(LogicException::class);

        $template = new MailTemplate('subject', [], 'body', 'text');
        $template->compile('foo', $this->createMock(RecipientInterface::class));
    }

    public function testMailTemplate()
    {
        $recipient = $this->createMock(RecipientInterface::class);
        $recipient->expects(self::once())->method('getInternalID');
        $recipient->expects(self::once())->method('getEmailIdentity')->willReturn('to@test.com');
        $recipient->expects(self::once())->method('getVars');

        $sender = $this->createMock(SenderInterface::class);
        $sender->expects(self::once())->method('getSenderIdentity')->willReturn('sender@test.com');
        $sender->expects(self::once())->method('getReplyToIdentity')->willReturn('reply@test.com');

        $template = new MailTemplate('subject', [], 'body', 'text');
        $template->setAttachments($attachment = new MailAttachment('path'));
        $message  = $template->compile('foo', $recipient, $sender);

        self::assertInstanceOf(MailMessage::class, $message);
        self::assertSame([$attachment], $message->getAttachments());
    }

    public function testSMSTemplateSenderRequired()
    {
        $this->expectException(LogicException::class);

        $template = new SMSTemplate('subject', []);
        $template->compile('foo', $this->createMock(RecipientInterface::class));
    }

    public function testSMSTemplate()
    {
        $recipient = $this->createMock(RecipientInterface::class);
        $recipient->expects(self::once())->method('getInternalID');
        $recipient->expects(self::once())->method('getPhoneIdentity');
        $recipient->expects(self::once())->method('getVars');

        $sender = $this->createMock(SenderInterface::class);
        $sender->expects(self::once())->method('getSenderIdentity');

        $template = new SMSTemplate('subject', []);
        $message  = $template->compile('foo', $recipient, $sender);

        self::assertInstanceOf(SMSMessage::class, $message);
    }

    public function testPushTemplate()
    {
        $recipient = $this->createMock(RecipientInterface::class);
        $recipient->expects(self::once())->method('getInternalID');
        $recipient->expects(self::once())->method('getPushIdentity');
        $recipient->expects(self::once())->method('getVars');

        $template = new PushTemplate('subject', []);
        $message  = $template->compile('foo', $recipient);

        self::assertInstanceOf(PushMessage::class, $message);
    }
}