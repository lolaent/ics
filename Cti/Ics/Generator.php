<?php
namespace Cti\Ics;

use Cti\Ics\Output\OutputInterface;

class Generator
{
    /**
     * @var OutputInterface
     */
    protected $output;

    public function __construct(OutputInterface $out)
    {
        $this->output = $out;
    }

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

        $this->output->add('BEGIN:VEVENT');
        $this->output->add(sprintf('UID:%s', md5($item->getStart()->format('YmdHis'))));
        $this->output->add(sprintf('DTSTART;TZID=%s:%s', $item->getStart()->getTimezone()->getName(), $item->getStart()->format('Ymd\THis')));
        $this->output->add(sprintf('DTEND;TZID=%s:%s', $item->getEnd()->getTimezone()->getName(), $item->getEnd()->format('Ymd\THis')));
        if (strlen($item->getName())) {
            $this->output->add(sprintf('SUMMARY:%s', $item->getName()));
        }
        if (strlen($item->getDescription())) {
            $this->output->add(sprintf('DESCRIPTION:%s', $item->getDescription()));
        }
        $this->output->add('END:VEVENT');

        return $this;
    }

    public function calendar(Calendar $item)
    {
        if ($item->isEmpty() && 0 == strlen($item->getName())) {
            return $this;
        }

        $this->output->add('BEGIN:VCALENDAR');
        $this->output->add('VERSION:2.0');
        $this->output->add(sprintf('PRODID:-//%s//%s//EN', 'Cloudtroopers Intl', 'CTI Ics Generator 1.0'));
        $this->output->add('CALSCALE:GREGORIAN');
        if (strlen($item->getName())) {
            $this->output->add(sprintf('X-WR-CALNAME:%s', $item->getName()));
        }

        $this->output->add('BEGIN:VTIMEZONE');
        $this->output->add(sprintf('TZID:%s', $item->getTimezone()));
        $this->output->add('END:VTIMEZONE');

        foreach ($item->getAll() as $event) {
            $this->event($event);
        }
        $this->output->add('END:VCALENDAR');

        return $this;
    }

    public function getOutput()
    {
        return $this->output;
    }
}
