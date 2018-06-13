<?php

namespace Waseem\Assessment\Intercom\Service\DistanceCalculator;

use Waseem\Assessment\Intercom\Service\DistanceCalculator as base;

/**
 * Basic Distance Calculator
 *
 * @author Waseem Ahmed <waseem_ahmed_dxb@outlook.com>
 * @version 1.0.0
 */
class Basic extends base
{
    /**
     * Basic distance calculator
     *
     * @source https://www.geodatasource.com/developers/php Geo IP resolution technique lead to this discovery which matches Great-Circle-Distance article's general formula
     * @param float $lat1
     * @param float $lon1
     * @param float $lat2
     * @param float $lon2
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
