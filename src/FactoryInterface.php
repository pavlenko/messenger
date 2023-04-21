<?php

namespace PE\Component\Messenger;

interface FactoryInterface
{
    public function supports(DSN $dsn): bool;

    public function createCollector(DSN $dsn): CollectorInterface;

    public function createTransport(DSN $dsn): TransportInterface;

    public function createValidator(DSN $dsn): ValidatorInterface;
}