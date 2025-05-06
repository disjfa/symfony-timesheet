<?php

namespace App\Calendar;

class CalendarEvent implements \JsonSerializable
{
    private string $id;
    private string $title;
    private \DateTimeInterface $start;
    private \DateTimeInterface $end;

    public function __construct(string $id, string $title, \DateTimeInterface $start, \DateTimeInterface $end)
    {
        $this->id = $id;
        $this->title = $title;
        $this->start = $start;
        $this->end = $end;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start' => $this->start->format(\DateTimeInterface::ATOM),
            'end' => $this->end->format(\DateTimeInterface::ATOM),
        ];
    }
}
