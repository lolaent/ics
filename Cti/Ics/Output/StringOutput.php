<?php
namespace Cti\Ics\Output;

use Cti\Ics\Output\OutputInterface;

class StringOutput implements OutputInterface
{
    /**
     * @var string
     */
    protected $output = '';

    /**
     * @inheritdoc
     */
    public function add($value)
    {
        $this->output .= sprintf("%s\r\n", $value);
    }

    /**
     * @inheritdoc
     */
    public function getAll()
    {
        return $this->output;
    }
}
