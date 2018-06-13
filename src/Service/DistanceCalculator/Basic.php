<?php

namespace Waseem\Assessment\Intercom\Service\DistanceCalculator;

/**
 * Basic Distance Calculator
 *
 * @author Waseem Ahmed <waseem_ahmed_dxb@outlook.com>
 * @version 1.1.0
 */
class Basic extends AbstractDistanceCalculator
{
    /**
     * Basic distance calculator
     *
     * @source https://www.geodatasource.com/developers/php Geo IP resolution technique lead to this discovery which matches Great-Circle-Distance article's general formula
     * @param float $lat1 Value in decimal degrees
     * @param float $lon1 Value in decimal degrees
     * @param float $lat2 Value in decimal degrees
     * @param float $lon2 Value in decimal degrees
     * @return float Returns distance (in KMs)
     */
    public function Calculate(float $lat1, float $lon1, float $lat2, float $lon2) : float
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);

        return parent::RadiansToKilometers($dist);
    }
}
