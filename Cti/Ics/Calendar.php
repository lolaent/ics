<?php
namespace Cti\Ics;

use Cti\Ics\Event;

/**
 * Class Calendar groups a collection of events.
 *
 * @package Cti\Ics
 */
class Calendar
{
    /**
     * @var Event[]
     */
    protected $events = array();

    /**
     * @var string
     */
    protected $timezone;

    public function __construct()
    {
        $this->setTimezone(date_default_timezone_get());
    }

    /**
     * Checks if current calendar contains any events.
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return count($this->events) ? false : true;
    }

    /**
     * Adds event to current calendar.
     *
     * @param \Cti\Ics\Event $item
     */
    public function add(Event $item)
    {
        $this->events[] = $item;
    }

    /**
     * @return Event[]
     */
    public function getAll()
    {
        return $this->events;
    }

    /**
     * @param string $value
     *
     * @return Calendar
     */
    public function setTimezone($value)
    {
        $this->timezone = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }
}
