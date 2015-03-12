<?php
namespace Cti\Ics;

class Generator
{
    protected $output = '';

    /**
     * @param Event $item
     *
     * @return Generator
     */
    public function event(Event $item)
    {
        if (is_null($item->getStart()) && is_null($item->getEnd()))
        {
            return $this;
        }

        $this->output .= "BEGIN:VEVENT\r\n";
        $this->output .= sprintf("UID:%s\r\n", md5($item->getStart()->format('YmdHis')));
        $this->output .= sprintf("DTSTART;TZID=%s:%s\r\n", $item->getStart()->getTimezone()->getName(), $item->getStart()->format('Ymd\THis'));
        $this->output .= sprintf("DTEND;TZID=%s:%s\r\n", $item->getEnd()->getTimezone()->getName(), $item->getEnd()->format('Ymd\THis'));
        if (strlen($item->getName())) {
            $this->output .= sprintf("SUMMARY:%s\r\n", $item->getName());
        }
        $this->output .= "END:VEVENT\r\n";

        return $this;
    }

    public function calendar(Calendar $item)
    {
        if ($item->isEmpty() && 0 == strlen($item->getName())) {
            return $this;
        }

        $this->output .= "BEGIN:VCALENDAR\r\n";
        $this->output .= "VERSION:2.0\r\n";
        $this->output .= sprintf("PRODID:-//%s//%s//EN\r\n", 'Cloudtroopers Intl', 'CTI Ics Generator 1.0');
        $this->output .= "CALSCALE:GREGORIAN\r\n";
        if (strlen($item->getName())) {
            $this->output .= sprintf("X-WR-CALNAME:%s\r\n", $item->getName());
        }

        $this->output .= "BEGIN:VTIMEZONE\r\n";
        $this->output .= sprintf("TZID:%s\r\n", $item->getTimezone());
        $this->output .= "END:VTIMEZONE\r\n";

        foreach ($item->getAll() as $event) {
            $this->event($event);
        }
        $this->output .= "END:VCALENDAR\r\n";

        return $this;
    }

    public function getOutput()
    {
        return $this->output;
    }
}
