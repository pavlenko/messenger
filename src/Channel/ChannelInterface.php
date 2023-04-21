<?php

namespace PE\Component\Messenger\Channel;

use PE\Component\Messenger\EventCollection;
use PE\Component\Messenger\Exception\ChannelException;
use PE\Component\Messenger\RecipientInterface;
use PE\Component\Messenger\Template\TemplateInterface;

interface ChannelInterface
{
    /**
     * Send templated message to a recipients list
     *
     * @param TemplateInterface $template
     * @param RecipientInterface ...$recipients
     * @return EventCollection
     * @throws ChannelException
     */
    public function send(TemplateInterface $template, RecipientInterface ...$recipients): EventCollection;
}