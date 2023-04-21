<?php

namespace PE\Component\Messenger;

use PE\Component\Messenger\Exception\TransportException;
use PE\Component\Messenger\Message\MessageInterface;

interface TransportInterface
{
    public function getName(): string;

    /**
     * Send messages via specific transport type
     *
     * @param MessageInterface ...$message
     * @throws TransportException
     */
    public function send(MessageInterface ...$message): void;
}