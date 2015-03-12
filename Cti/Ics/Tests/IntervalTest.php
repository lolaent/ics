<?php
namespace Cti\Ics\Tests;

use Cti\Ics\Event\Interval;

class IntervalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideInvalidDates
     * @expectedException \InvalidArgumentException
     */
    public function anonymousInvalidStart($start, $end)
    {
        $event = new Interval($start, $end);
    }

    /**
     * @test
     * @dataProvider provideValidDates
     */
    public function anonymousValidDates($start, $end)
    {
        $event = new Interval($start, $end);

        $this->assertInstanceOf('Cti\Ics\Event\Interval', $event);
    }

    /**
     * @test
     * @dataProvider provideValidDates
     */
    public function namedValidDates($start, $end, $name)
    {
        $event = new Interval($start, $end, $name);

        $this->assertInstanceOf('Cti\Ics\Event\Interval', $event);
        $this->assertEquals($name, $event->getName());
    }

    public function provideInvalidDates()
    {
        return array(
            array('asdf', null),
            array(null, 'qwerty'),
            array('1', null),
            array(null, '2'),
        );
    }

    public function provideValidDates()
    {
        return array(
            array(null, null, 'Right now'),
            array('today', 'tomorrow', 'Today and tomorrow'),
        );
    }
}
