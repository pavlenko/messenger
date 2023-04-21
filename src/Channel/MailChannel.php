<?php

namespace PE\Component\Messenger\Channel;

use PE\Component\Messenger\Template\MailTemplate;
use PE\Component\Messenger\Template\TemplateInterface;

/**
 * @codeCoverageIgnore Nothing to check
 */
final class MailChannel extends ChannelBase
{
    protected function supports(TemplateInterface $template): bool
    {
        return $template instanceof MailTemplate;
    }
}