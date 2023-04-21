<?php

namespace PE\Component\Messenger\Template;

use PE\Component\Messenger\Message\PushMessage;
use PE\Component\Messenger\RecipientInterface;
use PE\Component\Messenger\SenderInterface;

final class PushTemplate extends TemplateBase
{
    public function compile(string $transportName, RecipientInterface $recipient, SenderInterface $sender = null): PushMessage
    {
        $message = new PushMessage(
            $recipient->getInternalID(),
            $this->substitute($this->subject, $recipient->getVars() + $this->vars),
            $recipient->getPushIdentity($transportName),
            $sender ? $sender->getSenderIdentity() : null
        );
        $message->setTag($this->tag);
        return $message;
    }
}