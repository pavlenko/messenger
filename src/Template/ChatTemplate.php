<?php

namespace PE\Component\Messenger\Template;

use PE\Component\Messenger\Message\ChatMessage;
use PE\Component\Messenger\RecipientInterface;
use PE\Component\Messenger\SenderInterface;

final class ChatTemplate extends TemplateBase
{
    public function compile(string $transportName, RecipientInterface $recipient, SenderInterface $sender = null): ChatMessage
    {
        $message = new ChatMessage(
            $recipient->getInternalID(),
            $this->substitute($this->subject, $recipient->getVars() + $this->vars),
            $recipient->getChatIdentity($transportName),
            $sender ? $sender->getSenderIdentity() : null
        );
        $message->setTag($this->tag);
        return $message;
    }
}