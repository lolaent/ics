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
    public function blankEvent()
    {
        $event = new Event\Blank();
        $output = $this->generator->event($event)->getOutput();

        $this->assertEmptyString($output);
    }

    /**
     * @test
     */
    public function anonymousEventWithDuration()
    {
        $event = new Event\Interval('2015-03-11 12:34:56 Z', '2015-03-11 12:59:59 Z');
        $output = $this->generator->event($event)->getOutput();

        $this->assertNonEmptyString($output);
        $this->assertEventWrapper($output);
        $this->assertEventMandatories($output);
        $this->assertNotContains('DESCRIPTION:', $output);
    }

    /**
     * @test
     */
    public function namedEventWithDuration()
    {
        $event = new Event\Interval('2015-03-11 12:34:56 Z', '2015-03-11 12:59:59 Z', 'Your kind of meeting');
        $output = $this->generator->event($event)->getOutput();

        $this->assertNonEmptyString($output);
        $this->assertEventWrapper($output);
        $this->assertEventMandatories($output);
        $this->assertContains('DESCRIPTION:', $output);
    }

    /**
     * @test
     */
    public function eventEnforceTimezone()
    {
        $event = new Event\Interval('2015-03-11 12:34:56 Europe/Bucharest', '2015-03-11 12:59:59 Europe/Bucharest');
        $output = $this->generator->event($event)->getOutput();

        $this->assertNonEmptyString($output);
        $this->assertEventWrapper($output);
        $this->assertEventMandatories($output);
    }

    /**
     * @test
     */
    public function eventDefaultTimezone()
    {
        $event = new Event\Interval('2015-03-11 12:34:56', '2015-03-11 12:59:59');
        $output = $this->generator->event($event)->getOutput();

        $this->assertNonEmptyString($output);
        $this->assertEventWrapper($output);
        $this->assertContains('UID:', $output);
        $this->assertContains('DTSTART', $output);
        $this->assertContains('DTEND', $output);
    }

    /**
     * @test
     */
    public function blankCalendar()
    {
        $calendar = new Calendar();
        $output = $this->generator->calendar($calendar)->getOutput();

        $this->assertEmptyString($output);
    }

    /**
     * @test
     */
    public function namedBlankCalendar()
    {
        $calendar = new Calendar('Automated Test Calendar');
        $output = $this->generator->calendar($calendar)->getOutput();

        $this->assertNonEmptyString($output);
        $this->assertContains('X-WR-CALNAME:Automated Test Calendar', $output);
    }

    /**
     * @test
     */
    public function calendarUnnamedOneEvent()
    {
        $oldTimezone = date_default_timezone_get();
        date_default_timezone_set('Europe/Amsterdam');
        $calendar = new Calendar();
        $calendar->add(new Event\Interval('2015-03-11 12:34:56 Z', '2015-03-11 12:59:59 Z'));

        $output = $this->generator->calendar($calendar)->getOutput();
        date_default_timezone_set($oldTimezone);

        $this->assertNonEmptyString($output);
        $this->assertCalendarWrapper($output);
        $this->assertCalendarTimezone($output);
        $this->assertContains('TZID:Europe/Amsterdam', $output);
        $this->assertNotContains('X-WR-CALNAME', $output);
        $this->assertEventWrapper($output);
    }

    private function assertEmptyString($output)
    {
        $this->assertInternalType('string', $output);
        $this->assertEquals('', $output);
    }

    private function assertNonEmptyString($output)
    {
        $this->assertInternalType('string', $output);
        $this->assertGreaterThan(0, strlen($output));
    }

    private function assertEventWrapper($output)
    {
        $this->assertContains('BEGIN:VEVENT', $output);
        $this->assertContains('END:VEVENT', $output);
    }

    private function assertEventMandatories($output)
    {
        $this->assertContains('UID:', $output);
        $this->assertContains('DTSTART', $output);
        $this->assertContains('DTEND', $output);
    }

    private function assertCalendarWrapper($output)
    {
        $this->assertContains('BEGIN:VCALENDAR', $output);
        $this->assertContains('END:VCALENDAR', $output);

        $this->assertContains('PRODID', $output);
        $this->assertContains('CALSCALE:GREGORIAN', $output);
        $this->assertContains('VERSION:2.0', $output);
    }

    private function assertCalendarTimezone($output)
    {
        $this->assertContains('BEGIN:VTIMEZONE', $output);
        $this->assertContains('TZID:', $output);
        $this->assertContains('END:VTIMEZONE', $output);
    }
}
