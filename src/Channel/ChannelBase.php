<?php

namespace PE\Component\Messenger\Channel;

use PE\Component\Messenger\EventCollection;
use PE\Component\Messenger\Exception\ChannelException;
use PE\Component\Messenger\Exception\InvalidArgumentException;
use PE\Component\Messenger\Exception\TransportException;
use PE\Component\Messenger\Message\MessageInterface;
use PE\Component\Messenger\RecipientInterface;
use PE\Component\Messenger\SenderInterface;
use PE\Component\Messenger\Template\TemplateInterface;
use PE\Component\Messenger\TransportInterface;

abstract class ChannelBase implements ChannelInterface
{
    protected TransportInterface $transport;
    protected ?SenderInterface $sender;

    /**
     * Create channel with specific transport and optional sender
     *
     * @param TransportInterface $transport
     * @param SenderInterface|null $sender
     */
    public function __construct(TransportInterface $transport, SenderInterface $sender = null)
    {
        $this->transport = $transport;
        $this->sender    = $sender;
    }

    final public function send(TemplateInterface $template, RecipientInterface ...$recipients): EventCollection
    {
        if (!$this->supports($template)) {
            throw new InvalidArgumentException(sprintf(
                'Unsupported template type %s for channel %s',
                get_class($template),
                get_class($this)
            ));
        }

        if (count($recipients) === 0) {
            throw new InvalidArgumentException('Required at least one recipient');
        }

        try {
            $messages = [];
            foreach ($recipients as $recipient) {
                $messages[] = $template->compile($this->transport->getName(), $recipient, $this->sender);
            }

            $this->transport->send(...$messages);

            return new EventCollection(...array_map(fn(MessageInterface $m) => $m->toEvent(), $messages));
        } catch (TransportException $e) {
            throw new ChannelException($e->getMessage(), $e->getCode(), $e);
        }
    }

    abstract protected function supports(TemplateInterface $template): bool;
}