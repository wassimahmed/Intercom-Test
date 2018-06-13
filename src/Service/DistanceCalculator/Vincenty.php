<?php

namespace Waseem\Assessment\Intercom\Service\DistanceCalculator;

/**
 * Vincenty formula based distance calculator
 *
 * @author Waseem Ahmed <waseem_ahmed_dxb@outlook.com>
 * @version 1.2.0
 */
class Vincenty extends AbstractDistanceCalculator
{
    /**
     * Computes distance between two geographical points using Vincenty formula
     * Since general computational formula suffers from rounding-errors (for shorter distances), Vincenty formula is more reliable formula.
     *
     * @param float $lat1 Value in decimal degrees
     * @param float $lon1 Value in decimal degrees
     * @param float $lat2 Value in decimal degrees
     * @param float $lon2 Value in decimal degrees
     * @return float Returns distance (in KMs)
     */
    public function Calculate(float $lat1, float $lon1, float $lat2, float $lon2) : float
    {
        $theta = deg2rad($lon1 - $lon2);

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $divisor = sqrt(pow(cos($lat2) * sin($theta), 2) + pow(cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($theta), 2));
        $divider = sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($theta);

        $dist = atan($divisor / $divider);

        return parent::RadiansToKilometers($dist);
    }
}
