<?php

namespace PE\Component\Messenger;

interface SenderInterface
{
    /**
     * Get Sender identity
     *
     * @return string
     */
    public function getSenderIdentity(): string;

    /**
     * Get reply to identity, usable only for emails
     *
     * @return string|null
     */
    public function getReplyToIdentity(): ?string;
}