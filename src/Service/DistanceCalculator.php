<?php

namespace Waseem\Assessment\Intercom\Service;

/**
 * Distance Calculator service
 * Offers two formulas; basic and spherical based Vincenty formula
 *
 * @author Waseem Ahmed <waseem_ahmed_dxb@outlook.com>
 * @version 1.0.0
 */
class DistanceCalculator
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
    public static function Basic(float $lat1, float $lon1, float $lat2, float $lon2) : float
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);

        return static::RadiansToKM($dist);
    }

    /**
     * Computes distance using Vincenty formula
     * Since general computational formula suffers from rounding-errors (for shorter distances), more reliable formula is used.
     *
     * @param float $lat1
     * @param float $lon1
     * @param float $lat2
     * @param float $lon2
     * @return float Returns distance (in KMs)
     */
    public static function Vincenty(float $lat1, float $lon1, float $lat2, float $lon2) : float
    {
        $theta = $lon1 - $lon2;

        $divisor = sqrt(pow(cos($lat2) * sin($theta), 2) + pow(cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($theta), 2));
        $divider = sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($theta);
    
        $dist = atan2($divider, $divisor);

        return static::RadiansToKM($dist);
    }

    /**
     * Converts radians to kilometers
     *
     * @param float $value
     * @return float
     */
    public static function RadiansToKM(float $value) : float
    {
        // Radian to (decimal) Degree
        $dist = rad2deg($value);
    
        // Distance in miles
        $miles = $dist * 60 * 1.1515;
    
        // Miles to KM
        return ($miles * 1.609344);
    }
}
