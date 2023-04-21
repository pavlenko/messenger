<?php

namespace PE\Component\Messenger\Channel;

use PE\Component\Messenger\Template\ChatTemplate;
use PE\Component\Messenger\Template\TemplateInterface;

/**
 * @codeCoverageIgnore Nothing to check
 */
final class ChatChannel extends ChannelBase
{
    protected function supports(TemplateInterface $template): bool
    {
        return $template instanceof ChatTemplate;
    }
}