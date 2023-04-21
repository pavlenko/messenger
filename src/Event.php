<?php

namespace PE\Component\Messenger;

use PE\Component\Messenger\Message\MessageInterface;

/**
 * @codeCoverageIgnore Just DTO
 */
final class Event
{
    public const SENT_SUCCESS         = 'sent_success';
    public const SENT_FAILURE         = 'sent_failure';
    public const DELIVERY_SUCCESS     = 'delivery_success';
    public const DELIVERY_FAILURE     = 'delivery_failure';
    public const DELIVERY_BOUNCE_SOFT = 'delivery_bounce_soft';
    public const DELIVERY_BOUNCE_HARD = 'delivery_bounce_hard';
    public const FEEDBACK_OPEN        = 'feedback_open';
    public const FEEDBACK_CLICK       = 'feedback_click';
    public const FEEDBACK_SPAM        = 'feedback_spam';
    public const FEEDBACK_UNSUBSCRIBE = 'feedback_unsubscribe';
    public const INBOUND              = 'inbound';

    private string $type;
    private \DateTimeImmutable $date;
    private ?string $recipient = null;
    private ?string $externalMessageID = null;
    private ?string $internalMessageID = null;
    private ?string $userAgent = null;
    private ?string $ipAddress = null;
    private ?MessageInterface $message = null;

    public function __construct(string $type)
    {
        $this->type = $type;
        $this->date = new \DateTimeImmutable();
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    public function getRecipient(): ?string
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient): void
    {
        $this->recipient = $recipient;
    }

    public function getExternalMessageID(): ?string
    {
        return $this->externalMessageID;
    }

    public function setExternalMessageID(?string $externalMessageID): void
    {
        $this->externalMessageID = $externalMessageID;
    }

    public function getInternalMessageID(): ?string
    {
        return $this->internalMessageID;
    }

    public function setInternalMessageID(?string $internalMessageID): void
    {
        $this->internalMessageID = $internalMessageID;
    }

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function setUserAgent(?string $userAgent): void
    {
        $this->userAgent = $userAgent;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(?string $ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    public function getMessage(): ?MessageInterface
    {
        return $this->message;
    }

    public function setMessage(?MessageInterface $message): void
    {
        $this->message = $message;
    }
}