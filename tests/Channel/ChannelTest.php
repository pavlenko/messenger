<?php

namespace PE\Component\Messenger\Tests\Channel;

use PE\Component\Messenger\Channel\ChannelBase;
use PE\Component\Messenger\Exception\ChannelException;
use PE\Component\Messenger\Exception\InvalidArgumentException;
use PE\Component\Messenger\Exception\TransportException;
use PE\Component\Messenger\Message\MessageBase;
use PE\Component\Messenger\RecipientInterface;
use PE\Component\Messenger\Template\TemplateInterface;
use PE\Component\Messenger\TransportInterface;
use PHPUnit\Framework\TestCase;

class ChannelTest extends TestCase
{
    public function testSendUnsupportedTemplate()
    {
        $this->expectException(InvalidArgumentException::class);

        $channel = $this->getMockForAbstractClass(ChannelBase::class, [$this->createMock(TransportInterface::class)]);
        $channel->send($this->createMock(TemplateInterface::class));
    }

    public function testSendNoRecipients()
    {
        $this->expectException(InvalidArgumentException::class);

        $channel = $this->getMockForAbstractClass(ChannelBase::class, [$this->createMock(TransportInterface::class)]);
        $channel->method('supports')->willReturn(true);
        $channel->send($this->createMock(TemplateInterface::class));
    }

    public function testSendTransportFailed()
    {
        $this->expectException(ChannelException::class);

        $transport = $this->createMock(TransportInterface::class);
        $transport->expects(self::once())->method('send')->willThrowException(new TransportException());

        $channel = $this->getMockForAbstractClass(ChannelBase::class, [$transport]);
        $channel->method('supports')->willReturn(true);
        $channel->send($this->createMock(TemplateInterface::class), $this->createMock(RecipientInterface::class));
    }

    public function testSend()
    {
        $transport = $this->createMock(TransportInterface::class);
        $transport->expects(self::once())->method('send');

        $template = $this->createMock(TemplateInterface::class);
        $template->expects(self::once())->method('compile')->willReturn(
            $this->getMockForAbstractClass(MessageBase::class, ['q', 's', 'r'])
        );

        $channel = $this->getMockForAbstractClass(ChannelBase::class, [$transport]);
        $channel->method('supports')->willReturn(true);
        $channel->send($template, $this->createMock(RecipientInterface::class));
    }
}