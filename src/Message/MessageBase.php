<?php

namespace PE\Component\Messenger\Message;

use PE\Component\Messenger\DSN;
use PE\Component\Messenger\Event;
use PE\Component\Messenger\Exception\InvalidArgumentException;

abstract class MessageBase implements MessageInterface
{
    private ?DSN $dsn = null;
    private string $queueID;
    private string $subject;
    protected $recipient;
    protected $sender;
    private ?string $tag = null;
    private string $result = self::RESULT_PENDING;
    private ?string $messageID = null;
    private ?\Throwable $throwable = null;

    /**
     * @param string $queueID
     * @param string $subject
     * @param string|MailAddress $recipient
     * @param string|MailAddress $sender
     */
    public function __construct(string $queueID, string $subject, $recipient, $sender = null)
    {
        if (!is_string($recipient) && !$recipient instanceof MailAddress) {
            throw new InvalidArgumentException('Invalid recipient');
        }

        if (null !== $sender && !is_string($sender) && !$sender instanceof MailAddress) {
            throw new InvalidArgumentException('Invalid recipient');
        }

        $this->queueID   = $queueID;
        $this->subject   = $subject;
        $this->recipient = $recipient;
        $this->sender    = $sender;
    }

    public function getDSN(): ?DSN
    {
        return $this->dsn;
    }

    public function setDSN(?DSN $dsn): void
    {
        $this->dsn = $dsn;
    }

    public function getQueueID(): string
    {
        return $this->queueID;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(?string $tag): void
    {
        $this->tag = $tag;
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function getMessageID(): ?string
    {
        return $this->messageID;
    }

    public function getException(): ?\Throwable
    {
        return $this->throwable;
    }

    public function setSuccess(string $messageID): void
    {
        $this->result    = self::RESULT_SUCCESS;
        $this->messageID = $messageID;
    }

    public function setFailure(\Throwable $throwable): void
    {
        $this->result    = self::RESULT_FAILURE;
        $this->throwable = $throwable;
    }

    final public function toEvent(): Event
    {
        $event = new Event(self::RESULT_SUCCESS === $this->result ? Event::SENT_SUCCESS : Event::SENT_FAILURE);
        $event->setMessage($this);

        if (self::RESULT_SUCCESS !== $this->result) {
            $event->setInternalMessageID($this->messageID);
        } else {
            $event->setExternalMessageID($this->messageID);
        }

        return $event;
    }
}