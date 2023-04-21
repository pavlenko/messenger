<?php

namespace PE\Component\Messenger;

use PE\Component\Messenger\Exception\RuntimeException;

final class Recipient implements RecipientInterface
{
    private string $internalID;
    private array $vars;
    private array $identities;

    public function __construct(string $internalID, array $vars, array $identities)
    {
        $this->internalID = $internalID;
        $this->vars       = $vars;
        $this->identities = $identities;
    }

    public function getInternalID(): string
    {
        return $this->internalID;
    }

    public function getChatIdentity(string $transportName): string
    {
        if (isset($this->identities[$transportName])) {
            return $this->identities[$transportName];
        }

        throw new RuntimeException(sprintf('Chat identity %s not found', $transportName));
    }

    public function getEmailIdentity(): string
    {
        if (isset($this->identities['email'])) {
            return $this->identities['email'];
        }

        throw new RuntimeException('Email identity not found');
    }

    public function getPhoneIdentity(): string
    {
        if (isset($this->identities['phone'])) {
            return $this->identities['phone'];
        }

        throw new RuntimeException('Phone identity not found');
    }

    public function getPushIdentity(string $transportName): string
    {
        if (isset($this->identities[$transportName])) {
            return $this->identities[$transportName];
        }

        throw new RuntimeException(sprintf('Push identity %s not found', $transportName));
    }

    public function getVars(): array
    {
        return $this->vars;
    }
}