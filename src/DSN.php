<?php

namespace PE\Component\Messenger;

use PE\Component\Messenger\Exception\InvalidArgumentException;
use PE\Component\Messenger\Exception\RuntimeException;

final class DSN
{
    private string $scheme;
    private string $host;
    private ?string $user;
    private ?string $pass;
    private ?int $port;
    private array $options;

    public function __construct(
        string $scheme,
        string $host,
        string $user = null,
        string $pass = null,
        int $port = null,
        array $options = []
    ) {
        $this->scheme  = $scheme;
        $this->host    = $host;
        $this->user    = $user;
        $this->pass    = $pass;
        $this->port    = $port;
        $this->options = $options;
    }

    public function __toString(): string
    {
        $url = $this->scheme . '://';
        if (!empty($this->user)) {
            $url .= urlencode($this->user);
            if (!empty($this->pass)) {
                $url .= ':' . urlencode($this->pass);
            }
            $url .= '@';
        }
        $url .= $this->host;
        if (!empty($this->port)) {
            $url .= ':' . $this->port;
        }
        if (!empty($this->options)) {
            $url .= '?' . http_build_query($this->options);
        }
        return $url;
    }

    public static function fromString(string $dsn): self
    {
        $parsed = parse_url($dsn);

        if (false === $parsed) {
            throw new InvalidArgumentException(sprintf('The "%s" mailer DSN is invalid.', $dsn));
        }
        if (!isset($parsed['scheme']) || !isset($parsed['host'])) {
            throw new InvalidArgumentException(sprintf(
                'The "%s" mailer DSN must contain a scheme and a host (use "default" by default).',
                $dsn
            ));
        }

        $user = isset($parsed['user']) ? urldecode($parsed['user']) : null;
        $pass = isset($parsed['pass']) ? urldecode($parsed['pass']) : null;
        $port = $parsed['port'] ?? null;

        parse_str($parsed['query'] ?? '', $query);
        return new self($parsed['scheme'], $parsed['host'], $user, $pass, $port, $query);
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getUser(bool $checkNotEmpty = false): ?string
    {
        if ($checkNotEmpty && null === $this->user) {
            throw new RuntimeException('Username is not set.');
        }
        return $this->user;
    }

    public function getPass(bool $checkNotEmpty = false): ?string
    {
        if ($checkNotEmpty && null === $this->pass) {
            throw new RuntimeException('Password is not set.');
        }
        return $this->pass;
    }

    public function getPort(int $default = null): ?int
    {
        return $this->port ?? $default;
    }

    public function getOption(string $key, $default = null)
    {
        return $this->options[$key] ?? $default;
    }
}