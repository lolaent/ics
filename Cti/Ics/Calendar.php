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

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     */
    public function __construct($name = '', $timeZone = '')
    {
        $this->setTimezone($timeZone);
        $this->setName($name);
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
        if (empty($value)) {
            $value = date_default_timezone_get();
        }
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

    /**
     * @param string $value
     *
     * @return Calendar
     */
    public function setName($value)
    {
        $this->name = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
