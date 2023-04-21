<?php

namespace PE\Component\Messenger\Template;

use PE\Component\Messenger\Exception\LogicException;
use PE\Component\Messenger\Message\MailAddress;
use PE\Component\Messenger\Message\MailAttachment;
use PE\Component\Messenger\Message\MailMessage;
use PE\Component\Messenger\RecipientInterface;
use PE\Component\Messenger\SenderInterface;

final class MailTemplate extends TemplateBase
{
    private string $bodyHtml;
    private ?string $bodyText;
    private array $attachments = [];

    public function __construct(string $subject, array $vars, string $bodyHtml, string $bodyText = null, string $tag = null)
    {
        parent::__construct($subject, $vars, $tag);
        $this->bodyHtml = $bodyHtml;
        $this->bodyText = $bodyText;
    }

    public function compile(string $transportName, RecipientInterface $recipient, SenderInterface $sender = null): MailMessage
    {
        if (null === $sender) {
            throw new LogicException('Sender required');
        }

        $vars = $recipient->getVars() + $this->vars;

        $message = new MailMessage(
            $recipient->getInternalID(),
            $this->substitute($this->subject, $vars),
            MailAddress::fromString($recipient->getEmailIdentity()),
            MailAddress::fromString($sender->getSenderIdentity()),
            ($replyTo = $sender->getReplyToIdentity())
                ? MailAddress::fromString($replyTo)
                : null
        );

        $message->setBodyHtml($this->substitute($this->bodyHtml, $vars));
        if ($this->bodyText) {
            $message->setBodyText($this->substitute($this->bodyText, $vars));
        }

        $message->setTag($this->tag);
        $message->setAttachments(...$this->attachments);
        return $message;
    }

    public function setAttachments(MailAttachment ...$attachments): void
    {
        $this->attachments = $attachments;
    }
}