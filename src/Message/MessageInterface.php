<?php

namespace PE\Component\Messenger\Message;

use PE\Component\Messenger\DSN;
use PE\Component\Messenger\Event;

interface MessageInterface
{
    public const RESULT_PENDING = 'pending';
    public const RESULT_SUCCESS = 'success';
    public const RESULT_FAILURE = 'failure';

    public function getDSN(): ?DSN;

    public function setDSN(?DSN $dsn): void;

    public function getQueueID(): string;

    public function getSubject(): string;

    public function getRecipient();

    public function getSender();

    public function getTag(): ?string;

    public function setTag(?string $tag): void;

    public function getResult(): string;

    public function getMessageID(): ?string;

    public function getException(): ?\Throwable;

    /**
     * Set message result to SUCCESS and save $messageID
     *
     * @param string $messageID
     */
    public function setSuccess(string $messageID): void;

    /**
     * Set message result to FAILURE and save $exception
     *
     * @param \Throwable $throwable
     */
    public function setFailure(\Throwable $throwable): void;

    public function toEvent(): Event;
}