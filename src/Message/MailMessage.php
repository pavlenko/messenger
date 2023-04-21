<?php

namespace PE\Component\Messenger\Message;

/**
 * @codeCoverageIgnore Nothing to check
 */
final class MailMessage extends MessageBase
{
    private MailAddress $replyTo;
    private ?string $bodyText;
    private ?string $bodyHtml;
    private array $headers = [];
    private array $attachments = [];

    public function __construct(
        string $queueID,
        string $subject,
        MailAddress $recipient,
        MailAddress $sender,
        ?MailAddress $replyTo = null
    ) {
        parent::__construct($queueID, $subject, $recipient, $sender);
        $this->replyTo = $replyTo ?: $sender;
    }

    public function getRecipient(): MailAddress
    {
        return $this->recipient;
    }

    public function getSender(): MailAddress
    {
        return $this->sender;
    }

    public function getReplyTo(): MailAddress
    {
        return $this->replyTo;
    }

    public function setBodyText(string $bodyText): void
    {
        $this->bodyText = $bodyText;
    }

    public function getBodyText(): string
    {
        return $this->bodyText ?? '';
    }

    public function setBodyHtml(string $bodyHtml): void
    {
        $this->bodyHtml = $bodyHtml;
    }

    public function getBodyHtml(): string
    {
        return $this->bodyHtml ?? '';
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    public function getHeader(string $name): ?string
    {
        return $this->headers[$name] ?? null;
    }

    public function setHeader(string $name, string $value): void
    {
        $this->headers[$name] = $value;
    }

    public function delHeader(string $name): void
    {
        unset($this->headers[$name]);
    }

    /**
     * @return MailAttachment[]
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function setAttachments(MailAttachment ...$attachments): void
    {
        $this->attachments = $attachments;
    }
}