<?php

namespace Waseem\Assessment\Intercom\Library;

/**
 * Customer [Record] Filter
 * Filters out invalid records; improper JSON, missing fields, etc so upstream processes records reliably.
 *
 * @author Waseem Ahmed <waseem_ahmed_dxb@outlook.com>
 * @version 1.0.0
 */
class CustomerFilter extends \FilterIterator
{
    /** @var array Last valid record */
    private $lastRecord;

    /**
     * Check whether the current element of the iterator is acceptable
     *
     * @link  http://php.net/manual/en/filteriterator.accept.php
     * @return bool true if the current element is acceptable, otherwise false.
     */
    public function accept()
    {
        $line = $this->getInnerIterator()->current();

        if (empty($line) or ($record = json_decode($line, true, 2)) === false) {
            return false;
        }

        if (empty($record['user_id']) || empty($record['name']) || empty($record['latitude']) || empty($record['longitude'])) {
            return false;
        }

        // Casting types for further strengthen value check
        $record['user_id'] = intval($record['user_id']);
        $record['latitude'] = floatval($record['latitude']);
        $record['longitude'] = floatval($record['longitude']);

        if ($record['user_id'] === 0 || $record['latitude'] === 0 || $record['longitude'] === 0) {
            return false;
        }

        $this->lastRecord = $record;

        return true;
    }

    /**
     * Returns last valid record
     *
     * @return array
     */
    public function current()
    {
        return $this->lastRecord;
    }
}
