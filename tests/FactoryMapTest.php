<?php

namespace PE\Component\Messenger\Tests;

use PE\Component\Messenger\CollectorInterface;
use PE\Component\Messenger\Exception\LogicException;
use PE\Component\Messenger\FactoryInterface;
use PE\Component\Messenger\FactoryMap;
use PE\Component\Messenger\TransportInterface;
use PE\Component\Messenger\ValidatorInterface;
use PHPUnit\Framework\TestCase;

final class FactoryMapTest extends TestCase
{
    public function testCreateCollectorUnsupported()
    {
        $this->expectException(LogicException::class);
        (new FactoryMap())->createCollector('mail://host');
    }

    public function testCreateCollector()
    {
        $factory = $this->createMock(FactoryInterface::class);
        $factory->expects(self::once())->method('supports')->willReturn(true);

        self::assertInstanceOf(CollectorInterface::class, (new FactoryMap($factory))->createCollector('mail://host'));
    }

    public function testCreateTransportUnsupported()
    {
        $this->expectException(LogicException::class);
        (new FactoryMap())->createTransport('mail://host');
    }

    public function testCreateTransportU()
    {
        $factory = $this->createMock(FactoryInterface::class);
        $factory->expects(self::once())->method('supports')->willReturn(true);

        self::assertInstanceOf(TransportInterface::class, (new FactoryMap($factory))->createTransport('mail://host'));
    }

    public function testCreateValidatorUnsupported()
    {
        $this->expectException(LogicException::class);
        (new FactoryMap())->createValidator('mail://host');
    }

    public function testCreateValidator()
    {
        $factory = $this->createMock(FactoryInterface::class);
        $factory->expects(self::once())->method('supports')->willReturn(true);

        self::assertInstanceOf(ValidatorInterface::class, (new FactoryMap($factory))->createValidator('mail://host'));
    }
}