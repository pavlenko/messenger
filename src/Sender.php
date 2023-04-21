<?php

namespace PE\Component\Messenger;

/**
 * @codeCoverageIgnore Just DTO
 */
final class Sender implements SenderInterface
{
    private string $sender;
    private ?string $replyTo;

    public function __construct(string $sender, string $replyTo = null)
    {
        $this->sender  = $sender;
        $this->replyTo = $replyTo;
    }

    public function getSenderIdentity(): string
    {
        return $this->sender;
    }

    public function getReplyToIdentity(): ?string
    {
        return $this->replyTo;
    }
}