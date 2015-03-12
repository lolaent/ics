<?php
namespace Cti\Ics\Output;

interface OutputInterface
{
    /**
     * Feeds given value to the output in a new line
     *
     * @param string $value
     */
    public function add($value);

    /**
     * Grabs all current output
     *
     * @return string
     */
    public function getAll();
}
