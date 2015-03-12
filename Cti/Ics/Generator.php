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
        return $this;
    }

    public function getOutput()
    {
        return $this->output;
    }
}
