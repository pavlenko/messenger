<?php

namespace PE\Component\Messenger\Template;

use PE\Component\Messenger\Exception\LogicException;
use PE\Component\Messenger\Message\MessageInterface;
use PE\Component\Messenger\RecipientInterface;
use PE\Component\Messenger\SenderInterface;

interface TemplateInterface
{
    /**
     * Compile template to specific message type
     *
     * @param string $transportName
     * @param RecipientInterface $recipient
     * @param SenderInterface|null $sender
     * @return MessageInterface
     * @throws LogicException
     */
    public function compile(string $transportName, RecipientInterface $recipient, SenderInterface $sender = null): MessageInterface;
}