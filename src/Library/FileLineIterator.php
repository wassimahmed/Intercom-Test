<?php

namespace Waseem\Assessment\Intercom\Library;

/**
 * File Line Iterator
 * Implements iterator interface to read file contents line-by-line per iteration
 *
 * @author Waseem Ahmed <waseem_ahmed_dxb@outlook.com>
 * @version 1.0.0
 */
class FileLineIterator implements \Iterator
{
    /** @var string File path to read */
    private $path;

    /** @var string Last read line */
    private $line;

    /** @var resource File handle */
    private $handle;

    /**
     * Iterator constructor
     *
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        $this->path = $filePath;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        if (is_resource($this->handle)) {
            fclose($this->handle);
        }

        $this->line = $this->path = null;
    }

    /**
     * Open file to read
     * Uses {@see fopen} which supports reading from local file path and URL.
     * Thus it can be extended to read file off S3 or any remote URL.
     *
     * @return resource
     * @throws \RuntimeException Throws exception if file could not be read
     */
    protected function openFile()
    {
        if (!is_resource($this->handle)) {
            if (false === ($this->handle = fopen($this->path, 'r'))) {
                throw new \RuntimeException('Could not open file to read: '.$this->path);
            }
        }

        return $this->handle;
    }

    /**
     * Rewinds file internal pointer to beginning of the file
     *
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void
     */
    public function rewind()
    {
        $this->openFile();

        fseek($this->handle, 0);
    }

    /**
     * Return last read line from the file
     *
     * @link  http://php.net/manual/en/iterator.current.php
     * @return string
     */
    public function current()
    {
        return $this->line;
    }

    /**
     * Reads next line and moves file cursor forward
     *
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void
     */
    public function next()
    {
        $this->line = fgets($this->handle);
    }

    /**
     * [Empty interface implementation]
     *
     * @link  http://php.net/manual/en/iterator.key.php
     * @return null
     */
    public function key()
    {
        return null;
    }

    /**
     * Checks if end-of-file has reached
     *
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean
     */
    public function valid()
    {
        return !feof($this->handle);
    }
}
