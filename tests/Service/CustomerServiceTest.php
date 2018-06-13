<?php

use PHPUnit\Framework\TestCase;
use Waseem\Assessment\Intercom\Service\Customer;
use Waseem\Assessment\Intercom\Library\CustomerSorter;
use Waseem\Assessment\Intercom\Service\DistanceCalculator\Basic as BasicDistanceCalculator;

/**
 * @coversDefaultClass \Waseem\Assessment\Intercom\Service\Customer
 */
class CustomerServiceTest extends TestCase
{
    /**
     * @covers ::TransformRecord
     */
    public function testRecordTransformerStructure()
    {
        $instance = new Customer();
        $testData = [
            'key' => 'should-not-be-found',
            'name' => 'this-should-be-second',
            'user_id' => 'this-comes-first',
        ];

        $result = $instance->TransformRecord($testData);

        $this->assertTrue(is_array($result));
        $this->assertCount(2, $result);

        reset($result);
        $this->assertEquals('user_id', key($result));
        next($result);
        $this->assertEquals('name', key($result));
    }

    /**
     * @covers ::ReduceCustomersToInvite
     */
    public function testCustomersSkipped()
    {
        // Calculator mock will be called thrice and will return 3 different values
        $calculatorMock = $this->createMock(BasicDistanceCalculator::class);
        $calculatorMock->expects($this->exactly(3))
                       ->method('Calculate')
                       ->will($this->onConsecutiveCalls(10, 50, 101));

        // Sorter mock will be called once and will return its given argument as-is (i.e. without any sort)
        $sorterMock = $this->createMock(CustomerSorter::class);
        $sorterMock->expects($this->once())
                   ->method('Sort')
                   ->will($this->returnArgument(0));

        $testData = [
            [
                'user_id' => 10,
                'name' => 'first-valid-record',
                'latitude' => '53.123',
                'longitude' => '-6.123',
            ],
            [
                'user_id' => 5,
                'name' => 'second-valid-record',
                'latitude' => '53.123',
                'longitude' => '-6.123',
            ],
            [
                'user_id' => 15,
                'name' => 'in-valid-record',
                'latitude' => '56.123',
                'longitude' => '-6.123',
            ],
        ];

        $instance = new Customer();
        $result = $instance->ReduceCustomersToInvite(new \ArrayIterator($testData), $calculatorMock, $sorterMock);

        $this->assertTrue(is_array($result));
        $this->assertCount(2, $result);

        // Results are NOT sorted, so will be returned as-is
        reset($result);
        $this->assertEquals(10, current($result)['user_id']);
        next($result);
        $this->assertEquals(5, current($result)['user_id']);
    }
}