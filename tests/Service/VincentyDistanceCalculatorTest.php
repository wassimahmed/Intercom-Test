<?php

use PHPUnit\Framework\TestCase;
use Waseem\Assessment\Intercom\Service\DistanceCalculator\Vincenty as VincentyDistanceCalculator;

/**
 * @coversDefaultClass \Waseem\Assessment\Intercom\Service\DistanceCalculator\Vincenty
 */
class VincentyDistanceCalculatorTest extends TestCase
{
    public function testAllZeros()
    {
        $instance = new VincentyDistanceCalculator();
        $result = $instance->Calculate(0.0, 0.0, 0.0, 0.0);

        $this->assertSame(0.0, $result);
    }

    public function testTwoLatitudesDistance()
    {
        $instance = new VincentyDistanceCalculator();

        $result = $instance->Calculate(53.0, 0, 54.0, 0);

        // Since each degree of latitude is approx 69 miles (or 111km) apart, our result should be close to it.
        $this->assertGreaterThan(111.0, $result) and $this->assertLessThan(112.0, $result);
    }
}