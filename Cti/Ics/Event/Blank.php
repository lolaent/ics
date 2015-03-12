<?php
namespace Cti\Ics\Event;

use Cti\Ics\Event;

/**
 * Blank events are aimed at empty event instances.
 * Used more for proof of concept rather than practical usage.
 *
 * @package Cti\Ics\Event
 */
class Blank extends Event
{
    /**
     * Enforces start and end dates to be null.
     */
    public function __construct() {}
}
