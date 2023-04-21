<?php

namespace PE\Component\Messenger;

use PE\Component\Messenger\Exception\LogicException;

final class FactoryMap
{
    /**
     * @var FactoryInterface[]
     */
    private array $factories;

    public function __construct(FactoryInterface ...$factories)
    {
        $this->factories = $factories;
    }

    public function createCollector(string $dsn): CollectorInterface
    {
        $dsn = DSN::fromString($dsn);
        foreach ($this->factories as $factory) {
            if ($factory->supports($dsn)) {
                return $factory->createCollector($dsn);
            }
        }

        throw new LogicException('Unsupported DSN: ' . $dsn);
    }

    public function createTransport(string $dsn): TransportInterface
    {
        $dsn = DSN::fromString($dsn);
        foreach ($this->factories as $factory) {
            if ($factory->supports($dsn)) {
                return $factory->createTransport($dsn);
            }
        }

        throw new LogicException('Unsupported DSN: ' . $dsn);
    }

    public function createValidator(string $dsn): ValidatorInterface
    {
        $dsn = DSN::fromString($dsn);
        foreach ($this->factories as $factory) {
            if ($factory->supports($dsn)) {
                return $factory->createValidator($dsn);
            }
        }

        throw new LogicException('Unsupported DSN: ' . $dsn);
    }
}