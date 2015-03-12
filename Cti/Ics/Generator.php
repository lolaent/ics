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
        $this->output .= sprintf("DTSTART;VALUE=DATE:%s\r\n", $item->getStart()->format('Ymd\THis.P'));
        $this->output .= sprintf("DTEND;VALUE=DATE:%s\r\n", $item->getEnd()->format('Ymd\THis.P'));
        $this->output .= "END:VEVENT\r\n";

        return $this;
    }

    public function calendar(Calendar $item)
    {
        if ($item->isEmpty()) {
            return $this;
        }

        $this->output .= "BEGIN:VCALENDAR\r\n";
        $this->output .= sprintf("PRODID:-//%s//%s//EN\r\n", 'Cloudtroopers Intl', 'CTI Ics Generator 1.0');
        $this->output .= "CALSCALE:GREGORIAN\r\n";
        $this->output .= "VERSION:2.0\r\n";
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
