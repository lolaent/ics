<?php
namespace Cti\Ics;

abstract class Event
{
    /**
     * @var \DateTime
     */
    protected $start;

    /**
     * @var \DateTime
     */
    protected $end;

    /**
     * @var string
     */
    protected $name;

    public function __construct($start = null, $end = null)
    {
        $this->setStart($start);
        $this->setEnd($end);
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function setStart($start = null)
    {
        if (is_null($start)) {
            return;
        }

        $this->start = $this->toDateTime($start);
    }

    public function setEnd($end = null)
    {
        if (is_null($end)) {
            return;
        }

        $this->end = $this->toDateTime($end);
    }

    protected function toDateTime($value)
    {
        $dateTime = new \DateTime($value);
        if (is_null($dateTime)) {
            throw new \LogicException(sprintf('Invalid date provideds: %s', $dateTime));
        }

        return $dateTime;
    }

    /**
     * @param string $value
     *
     * @return Event
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
