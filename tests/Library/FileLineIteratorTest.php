<?php

use PHPUnit\Framework\TestCase;
use Waseem\Assessment\Intercom\Library\FileLineIterator;

/**
 * @coversDefaultClass \Waseem\Assessment\Intercom\Library\FileLineIterator
 */
class FileLineIteratorTest extends TestCase
{
    /**
     * Tests for PHP warning when file cannot be read
     *
     * @expectedException PHPUnit\Framework\Error\Warning
     */
    public function testFileOpenError()
    {
        $instance = new FileLineIterator('/try/opening/this/file');
        $instance->rewind();
    }

    public function testReadTestFileContentsOnce()
    {
        $instance = new FileLineIterator(__DIR__.'/testData.txt');
        $lines = [];

        $this->readLinesForTest($instance, $lines);

        $this->assertFalse($instance->valid());
        $this->assertCount(3, $lines);
    }

    public function testReadTestFileContentsMultipleTimes()
    {
        $instance = new FileLineIterator(__DIR__.'/testData.txt');
        $lines = [];

        for ($j = 0; $j < 3; $j++) {
            $this->readLinesForTest($instance, $lines);
        }

        $this->assertFalse($instance->valid());
        $this->assertCount(3 * 3, $lines);
    }

    private function readLinesForTest(FileLineIterator $instance, array &$buffer)
    {
        $instance->rewind();

        for ($i = 0; $i < 3; $i++) {
            $this->assertTrue($instance->valid());

            $buffer[] = $instance->current();

            $this->assertNull($instance->key());

            $instance->next();
        }
    }
}