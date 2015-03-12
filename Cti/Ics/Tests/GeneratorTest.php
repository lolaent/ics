<?php

namespace Cti\Ics\Tests;

use Cti\Ics\Generator;
use Cti\Ics\Event;
use Cti\Ics\Calendar;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Generator
     */
    protected $generator;

    public function setUp()
    {
        $this->generator = new Generator();
    }

    /**
     * @test
     */
    public function emptyEvent()
    {
        $event = new Event();
        $output = $this->generator->event($event)->getOutput();

        $this->assertEmptyString($output);
    }

    /**
     * @test
     */
    public function eventWithDuration()
    {
        $event = new Event('2015-03-11 12:34:56 Z', '2015-03-11 12:59:59 Z');
        $output = $this->generator->event($event)->getOutput();

        $this->assertInternalType('string', $output);
        $this->assertContains('BEGIN:VEVENT', $output);
        $this->assertContains('END:VEVENT', $output);
        $this->assertContains('UID:', $output);
        $this->assertContains('DTSTART', $output);
        $this->assertContains('DTEND', $output);
    }

    /**
     * @test
     */
    public function emptyCalendar()
    {
        $calendar = new Calendar();
        $output = $this->generator->calendar($calendar)->getOutput();

        $this->assertEmptyString($output);
    }

    /**
     * @test
     */
    public function calendarWithOneEvent()
    {
        $calendar = new Calendar();
        $calendar->add(new Event\Interval('2015-03-11 12:34:56 Z', '2015-03-11 12:59:59 Z'));

        $output = $this->generator->calendar($calendar)->getOutput();

        $this->assertInternalType('string', $output);
        $this->assertContains('BEGIN:VCALENDAR', $output);
        $this->assertContains('END:VCALENDAR', $output);
        $this->assertContains('BEGIN:VEVENT', $output);
        $this->assertContains('END:VEVENT', $output);

        $this->assertContains('PRODID', $output);
        $this->assertContains('CALSCALE:GREGORIAN', $output);
        $this->assertContains('VERSION:2.0', $output);
    }

    private function assertEmptyString($output)
    {
        $this->assertInternalType('string', $output);
        $this->assertEquals('', $output);
    }
}
