<?php

namespace PE\Component\Messenger\Message;

final class MailAttachment
{
    private string $path;
    private ?string $name;
    private ?string $type;
    private ?string $data;

    public function __construct(string $path, ?string $name = null, ?string $type = null, ?string $data = null)
    {
        $this->path = $path;
        $this->name = $name;
        $this->type = $type;
        $this->data = $data;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(?string $data): void
    {
        $this->data = $data;
    }

    public function load(): self
    {
        $this->setData(file_get_contents($this->path));
        return $this;
    }
}
