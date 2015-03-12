<?php
namespace Cti\Ics\Event;

use Cti\Ics\Event;

/**
 * Class Interval models an event that is constructed based on a start and end date.
 * The dates can be any string that allows PHP to create a \DateTime object.
 *
 * @package Cti\Ics\Event
 */
class Interval extends Event
{
    /**
     * Enforces start and end dates to be non-null.
     *
     * @param string $start
     * @param string $end
     */
    public function __construct($start, $end, $name = '')
    {
        $this->validate($start, $end);

        parent::__construct($start, $end);
        $this->setName($name);
    }

    /**
     * Ensures the values are valid before populating the current instance
     *
     * @param mixed $start
     * @param mixed $end
     */
    protected function validate($start, $end)
    {
        $this->toDateTime($start);
        $this->toDateTime($end);
    }
}
