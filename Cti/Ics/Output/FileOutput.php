<?php
namespace Cti\Ics\Output;

use Cti\Ics\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class FileOutput implements OutputInterface
{
    /**
     * @var string
     */
    protected $output = '';

    /**
     * @var string
     */
    protected $path = '';

    public function __construct($path)
    {
        $this->path = $path;
    }

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
        $filesystem = new Filesystem();
        $filesystem->dumpFile($this->path, $this->output);

        return true;
    }
}
