<?php

const FOCAL_POINT_LATITUDE = 53.339428;
const FOCAL_POINT_LONGITUDE = -6.257664;
const FOCAL_POINT_RADIUS_KM = 100;

function process(string $filePath) : array
{
    $handle = fopen($filePath, 'r');
    if ($handle === false) {
        throw new \Exception('Unable to read file: '.$filePath);
    }

    $result = array();

    // Read one line at a time until EOF
    while (($line = fgets($handle)) !== false) {
        if (empty($line) || ($record = json_decode($line, true, 2)) == false || !is_array($record)) {
            continue;
        }

        if (empty($record['user_id']) || empty($record['name']) || empty($record['latitude']) || empty($record['longitude'])) {
            continue;
        }

        // Calculating distance
        $d = distanceVincenty(FOCAL_POINT_LATITUDE, FOCAL_POINT_LONGITUDE, $record['latitude'], $record['longitude']);
        if ($d < FOCAL_POINT_RADIUS_KM) {
            $result[] = $record;
        }
    }

    fclose($handle);

    return $result;
}

function distanceBasic($lat1, $lon1, $lat2, $lon2) 
{
    // source: https://www.geodatasource.com/developers/php
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;

    // Miles to KM
    return ($miles * 1.609344);
}

function distanceVincenty($lat1, $lon1, $lat2, $lon2)
{
    $theta = $lon1 - $lon2;

    $divisor = sqrt(pow(cos($lat2) * sin($theta), 2) + pow(cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($theta), 2));
    $divider = sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($theta);

    $dist = atan2($divider, $divisor);
    $dist = rad2deg($value);
    $miles = $dist * 60 * 1.1515;

    // Miles to KM
    return ($miles * 1.609344);
}

var_dump(process('asset/customers.txt'));
