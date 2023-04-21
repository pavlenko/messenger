<?php

namespace PE\Component\Messenger\Tests\Message;

use PE\Component\Messenger\Message\MailAttachment;
use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;

final class MailAttachmentTest extends TestCase
{
    use PHPMock;

    public function testAttachment()
    {
        $f = $this->getFunctionMock('PE\Component\Messenger\Message', 'file_get_contents');
        $f->expects(self::once())->willReturn('data');

        $a = new MailAttachment('path', 'name', 'type');

        self::assertSame('path', $a->getPath());
        self::assertSame('name', $a->getName());
        self::assertSame('type', $a->getType());
        self::assertNull($a->getData());

        $a->load();
        self::assertSame('data', $a->getData());
    }
}