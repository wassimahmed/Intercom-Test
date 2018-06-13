<?php

use PHPUnit\Framework\TestCase;
use Waseem\Assessment\Intercom\Library\CustomerSorter;

/**
 * @coversDefaultClass \Waseem\Assessment\Intercom\Library\CustomerSorter
 */
class CustomerSorterTest extends TestCase
{
    /**
     * Tests for exception been thrown when unknown field is set for sorting
     *
     * @expectedException InvalidArgumentException
     */
    public function testThrowsExceptionForUnknownField()
    {
        $instance = new CustomerSorter();
        $instance->setSortField('un-supported-field');
    }

    /**
     * Tests for exception been thrown when unknown sort order
     *
     * @expectedException InvalidArgumentException
     */
    public function testThrowsExceptionForUnknownSortOrder()
    {
        $instance = new CustomerSorter();
        $instance->setSortOrder(2);
    }

    /**
     * Tests for exception been thrown when unexpected data-type is send in for sorting
     *
     * @expectedException InvalidArgumentException
     */
    public function testThrowsExceptionForNonArray()
    {
        $data = [
            ['valid' => false, 'reason' => 'well, sort key would not match'],
            '{"user_id": 10, "name": "sort expects array not JSON"}',
        ];

        $instance = new CustomerSorter();
        $instance->Sort($data);
    }

    public function testSortIdAsc()
    {
        $data = [
            ["user_id" => 10, "name" => "rec 1"],
            ["user_id" => 8, "name" => "rec 2"],
        ];

        $instance = new CustomerSorter();
        $result = $instance->Sort($data);

        $this->assertTrue(is_array($result));
        $this->assertCount(2, $result);

        $this->assertEquals(CustomerSorter::FIELD_USER_ID, $instance->getSortField());
        $this->assertEquals(SORT_ASC, $instance->getSortOrder());

        reset($result);
        $this->assertSame(8, current($result)['user_id']);
        next($result);
        $this->assertSame(10, current($result)['user_id']);
    }

    public function testSortNameDesc()
    {
        $data = [
            ["user_id" => 10, "name" => "amazing spiderman"],
            ["user_id" => 8, "name" => "z nation"],
        ];

        $instance = new CustomerSorter();
        $instance->setSortField(CustomerSorter::FIELD_NAME)->setSortOrder(SORT_DESC);
        $result = $instance->Sort($data);

        $this->assertTrue(is_array($result));
        $this->assertCount(2, $result);

        $this->assertEquals(CustomerSorter::FIELD_NAME, $instance->getSortField());
        $this->assertEquals(SORT_DESC, $instance->getSortOrder());

        reset($result);
        $this->assertStringStartsWith('z', current($result)['name']);
        next($result);
        $this->assertStringStartsWith('a', current($result)['name']);
    }
}
