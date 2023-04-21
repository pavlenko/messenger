<?php

namespace PE\Component\Messenger\Channel;

use PE\Component\Messenger\Template\PushTemplate;
use PE\Component\Messenger\Template\TemplateInterface;

/**
 * @codeCoverageIgnore Nothing to check
 */
final class PushChannel extends ChannelBase
{
    protected function supports(TemplateInterface $template): bool
    {
        return $template instanceof PushTemplate;
    }
}