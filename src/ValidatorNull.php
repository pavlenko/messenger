<?php

namespace PE\Component\Messenger;

/**
 * @codeCoverageIgnore Just dummy implementation
 */
final class ValidatorNull implements ValidatorInterface
{
    public function validate(DSN $dsn): array
    {
        return [];
    }
}