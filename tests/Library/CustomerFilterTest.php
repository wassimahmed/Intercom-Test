<?php

use PHPUnit\Framework\TestCase;
use Waseem\Assessment\Intercom\Library\CustomerFilter;

/**
 * @coversDefaultClass \Waseem\Assessment\Intercom\Library\CustomerFilter
 */
class CustomerFilterTest extends TestCase
{
    /**
     * @covers ::accept
     * @covers ::current
     */
    public function testValidJson()
    {
        $iterator = new \ArrayIterator([
            '{"user_id": "10", "name": "someone", "latitude": "53.1234", "longitude": "23.1234"}',
        ]);

        $instance = new CustomerFilter($iterator);
        $instance->rewind();

        $this->assertTrue($instance->valid());

        $record = $instance->current();
        $this->assertTrue(is_array($record));

        $this->assertArrayHasKey('user_id', $record);
        $this->assertSame($record['user_id'], 10);

        $this->assertArrayHasKey('name', $record);
        $this->assertSame($record['name'], 'someone');

        $this->assertArrayHasKey('latitude', $record);
        $this->assertSame($record['latitude'], floatval('53.1234'));

        $this->assertArrayHasKey('longitude', $record);
        $this->assertSame($record['longitude'], floatval('23.1234'));
    }

    /**
     * @covers ::accept
     * @covers ::current
     */
    public function testInvalidJson()
    {
        $iterator = new \ArrayIterator([
            'This is not a valid JSON record, hence must be filtered out',
            '{"invalid": "true", "reason": "Invalid customer record structure"}',
            '{"name": "oops-missing-id", "latitude": "53.1234", "longitude": "23.1234"}',
            '{"user_id": 0, "name": "", "latitude": "0", "longitude": "0"}',
            '[{"user_id": "10", "name": "this-is-invalid-too;nested!", "latitude": "53.1234", "longitude": "23.1234"}]',
        ]);

        $instance = new CustomerFilter($iterator);
        $instance->rewind();

        $this->assertFalse($instance->valid());

        $record = $instance->current();
        $this->assertNull($record);
    }
}
