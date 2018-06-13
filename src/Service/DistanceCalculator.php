<?php

namespace Waseem\Assessment\Intercom\Service;

/**
 * [Spherical] Distance Calculator
 *
 * @author Waseem Ahmed <waseem_ahmed_dxb@outlook.com>
 * @version 1.1.0
 */
abstract class DistanceCalculator
{
    abstract public function Calculate(float $lat1, float $lon1, float $lat2, float $lon2) : float;

    /**
     * Converts radians to kilometers
     *
     * @param float $value
     * @return float
     */
    public function RadiansToKilometers(float $value) : float
    {
        // Radian to (decimal) Degree
       $dist = rad2deg($value);
    
        // Distance in miles where each degree is ~69.09 miles
        // see: https://www.thoughtco.com/degree-of-latitude-and-longitude-distance-4070616
        $miles = $dist * 60 * 1.1515;
    
        // Miles to KM
        return ($miles * 1.609344);
    }
}
