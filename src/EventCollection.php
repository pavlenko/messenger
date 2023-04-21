<?php

namespace PE\Component\Messenger;

/**
 * @codeCoverageIgnore Just DTO
 */
final class EventCollection implements \Countable, \Iterator
{
    /**
     * @var Event[]
     */
    private array $events;

    public function __construct(Event ...$events)
    {
        $this->events = $events;
    }

    public function add(Event $event): void
    {
        $this->events[] = $event;
    }

    public function current(): ?Event
    {
        return current($this->events) ?? null;
    }

    public function next(): void
    {
        next($this->events);
    }

    public function key(): ?int
    {
        return key($this->events) ?: null;
    }

    public function valid(): bool
    {
        return key($this->events) !== null;
    }

    public function rewind(): void
    {
        reset($this->events);
    }

    public function count(): int
    {
        return count($this->events);
    }
}