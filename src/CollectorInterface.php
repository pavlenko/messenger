<?php

namespace PE\Component\Messenger;

use Psr\Http\Message\ServerRequestInterface;

interface CollectorInterface
{
    public function collectWebhook(ServerRequestInterface $request): EventCollection;

    public function collectInbound(ServerRequestInterface $request): EventCollection;
}
