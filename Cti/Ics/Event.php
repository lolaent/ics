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

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $location;

    /**
     * @param string|null $start
     * @param string|null $end
     * @param string|null $name
     * @param string|null $description
     * @param string|null $url
     * @param string|null $location
     */
    public function __construct($start = null, $end = null, $name = null, $description = null, $url = null, $location = null)
    {
        $this->setStart($start);
        $this->setEnd($end);
        $this->setName($name);
        $this->setDescription($description);
        $this->setUrl($url);
        $this->setLocation($location);
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
        try {
            $dateTime = new \DateTime($value);
        } catch(\Exception $e) {
            throw new \InvalidArgumentException(sprintf('Invalid date provided: %s', $value));
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

    /**
     * @param string $value
     *
     * @return Event
     */
    public function setDescription($value)
    {
        $this->description = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Event
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     *
     * @return Event
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }
}
