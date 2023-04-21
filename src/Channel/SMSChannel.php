<?php

namespace PE\Component\Messenger\Channel;

use PE\Component\Messenger\Template\SMSTemplate;
use PE\Component\Messenger\Template\TemplateInterface;

/**
 * @codeCoverageIgnore Nothing to check
 */
final class SMSChannel extends ChannelBase
{
    protected function supports(TemplateInterface $template): bool
    {
        return $template instanceof SMSTemplate;
    }
}