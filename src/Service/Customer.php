<?php

namespace Waseem\Assessment\Intercom\Service;

use Waseem\Assessment\Intercom\Library\CustomerSorter;
use Waseem\Assessment\Intercom\Service\DistanceCalculator\AbstractDistanceCalculator;

/**
 * Customer service
 *
 * @author Waseem Ahmed <waseem_ahmed_dxb@outlook.com>
 * @version 1.1.0
 */
class Customer
{
    const FOCAL_POINT_LATITUDE = 53.339428;
    const FOCAL_POINT_LONGITUDE = -6.257664;
    const FOCAL_POINT_RADIUS_KM = 100;

    /**
     * Reduces customer records for invitation
     * Reads customer-record from source, calculates distance for eligibility, and finally returns sorted result
     *
     * @param \Iterator                   $source      Data-source of customer records
     * @param AbstractDistanceCalculator  $calculator  Distance compute helper
     * @param CustomerSorter              $sorter      Customer-record sort helper
     * @return array
     */
    public function ReduceCustomersToInvite(\Iterator $source, AbstractDistanceCalculator $calculator, CustomerSorter $sorter) : array
    {
        $result = array();

        // Read one line at a time until EOF
        foreach ($source as $record) {
            // Calculating distance
            $d = $calculator->Calculate(self::FOCAL_POINT_LATITUDE, self::FOCAL_POINT_LONGITUDE, $record['latitude'], $record['longitude']);
            if ($d <= self::FOCAL_POINT_RADIUS_KM) {
                $result[] = $this->TransformRecord($record);
            }
        }

        return $sorter->Sort($result);
    }

    /**
     * Transforms customer record
     * 'View' consumption based transformation applied to given customer record
     *
     * @param array $record
     * @return array
     */
    public function TransformRecord(array $record) : array
    {
        return [
            'user_id' => $record['user_id'],
            'name'    => $record['name'],
        ];
    }
}
