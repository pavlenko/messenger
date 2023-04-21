<?php

namespace PE\Component\Messenger\Message;

/**
 * @codeCoverageIgnore Nothing to check
 */
final class PushMessage extends MessageBase
{
    public function __construct(string $queueID, string $subject, string $recipient, string $sender = null)
    {
        parent::__construct($queueID, $subject, $recipient, $sender);
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }
}