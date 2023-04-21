<?php

namespace PE\Component\Messenger;

abstract class TransportBase implements TransportInterface
{
    final public function getName(): string
    {
        return basename(str_replace('\\', '/', get_class($this)));
    }
}