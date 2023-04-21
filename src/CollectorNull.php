<?php

namespace PE\Component\Messenger;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @codeCoverageIgnore Just dummy implementation
 */
final class CollectorNull implements CollectorInterface
{
    public function collectWebhook(ServerRequestInterface $request): EventCollection
    {
        return new EventCollection();
    }

    public function collectInbound(ServerRequestInterface $request): EventCollection
    {
        return new EventCollection();
    }
}