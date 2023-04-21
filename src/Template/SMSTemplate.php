<?php

namespace PE\Component\Messenger\Template;

use PE\Component\Messenger\Exception\LogicException;
use PE\Component\Messenger\Message\SMSMessage;
use PE\Component\Messenger\RecipientInterface;
use PE\Component\Messenger\SenderInterface;

final class SMSTemplate extends TemplateBase
{
    public function compile(string $transportName, RecipientInterface $recipient, SenderInterface $sender = null): SMSMessage
    {
        if (null === $sender) {
            throw new LogicException('Sender required');
        }

        $message = new SMSMessage(
            $recipient->getInternalID(),
            $this->substitute($this->subject, $recipient->getVars() + $this->vars),
            $recipient->getPhoneIdentity(),
            $sender->getSenderIdentity()
        );
        $message->setTag($this->tag);
        return $message;
    }
}