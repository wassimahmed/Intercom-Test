<?php

namespace Waseem\Assessment\Intercom\Service\DistanceCalculator;

use Waseem\Assessment\Intercom\Service\DistanceCalculator as base;

/**
 * Vincenty formula based distance calculator
 *
 * @author Waseem Ahmed <waseem_ahmed_dxb@outlook.com>
 * @version 1.0.0
 */
class Vincenty extends base
{
    /**
     * Computes distance between two geographical points using Vincenty formula
     * Since general computational formula suffers from rounding-errors (for shorter distances), Vincenty formula is more reliable formula.
     *
     * @param float $lat1
     * @param float $lon1
     * @param float $lat2
     * @param float $lon2
     * @return float Returns distance (in KMs)
     */
    public function Calculate(float $lat1, float $lon1, float $lat2, float $lon2) : float
    {
        $theta = $lon1 - $lon2;

        $divisor = sqrt(pow(cos($lat2) * sin($theta), 2) + pow(cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($theta), 2));
        $divider = sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($theta);
    
        $dist = atan2($divider, $divisor);

        return parent::RadiansToKilometers($dist);
    }
}
