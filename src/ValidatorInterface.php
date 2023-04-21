<?php

namespace PE\Component\Messenger;

interface ValidatorInterface
{
    public function validate(DSN $dsn): array;
}
