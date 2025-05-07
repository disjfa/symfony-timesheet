<?php

namespace App\Calendar;

use Spatie\Color\Contrast;
use Spatie\Color\Named;

class CalendarEvent implements \JsonSerializable
{
    private string $id;
    private string $title;
    private \DateTimeInterface $start;
    private \DateTimeInterface $end;
    private string $backgroundColor;
    private string $textColor;

    public function __construct(string $id, string $title, \DateTimeInterface $start, \DateTimeInterface $end, string $backgroundColor = 'aliceblue')
    {
        $this->id = $id;
        $this->title = $title;
        $this->start = $start;
        $this->end = $end;
        $this->backgroundColor = $backgroundColor;
        $color = Named::fromString($backgroundColor);

        $ratio = Contrast::ratio(Named::fromString('black'), $color);
        if ($ratio > 8) {
            $this->textColor = 'black';
        } else {
            $this->textColor = 'white';
        }
        $this->title = $ratio.$this->title;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start' => $this->start->format('Y-m-d H:i:s'),
            'end' => $this->end->format('Y-m-d H:i:s'),
            'backgroundColor' => $this->backgroundColor,
            'textColor' => $this->textColor,
        ];
    }
}
