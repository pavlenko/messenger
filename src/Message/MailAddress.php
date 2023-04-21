<?php

namespace PE\Component\Messenger\Message;

use PE\Component\Messenger\Exception\InvalidArgumentException;

final class MailAddress
{
    private string $email;
    private ?string $name;

    public function __construct(string $email, ?string $name = null)
    {
        $this->email = $email;
        $this->name  = $name;
    }

    public static function fromString(string $address): self
    {
        if (preg_match('/^(?<n>(?:\S+\s)*\S+)\s<(?<m1>\S+@\S+\.\S+)>|(?<m2>\S+@\S+\.\S+)$/', $address, $m)) {
            return new self(!empty($m['n']) ? $m['m1'] : $m['m2'], $m['n'] ?: null);
        }

        throw new InvalidArgumentException('Invalid address');
    }

    public function __toString(): string
    {
        return (!empty($this->name))
            ? $this->name . ' <' . $this->email . '>'
            : $this->email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
