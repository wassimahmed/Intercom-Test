<?php

namespace Waseem\Assessment\Intercom\Library;

/**
 * Customer [Record] Sorter
 * Sorts customer records
 *
 * @author Waseem Ahmed <waseem_ahmed_dxb@outlook.com>
 * @version 1.0.0
 */
class CustomerSorter
{
    const FIELD_USER_ID = 'user_id';
    const FIELD_NAME = 'name';

    /** @var string Name of the field to sort on */
    private $field = self::FIELD_USER_ID;

    /** @var int Sort order. Supported values: SORT_ASC, SORT_DESC */
    private $order = SORT_ASC;

    /**
     * Gets sorting field name
     *
     * @return string
     */
    public function getSortField()
    {
        return $this->field;
    }

    /**
     * Sets sorting field name
     *
     * @param string $field Name of the field to sort records on
     * @return self Returns self for Fluent interface
     * @throws \InvalidArgumentException Throws exception for unsupported value
     */
    public function setSortField($field)
    {
        if (in_array($field, [self::FIELD_USER_ID, self::FIELD_NAME])) {
            $this->field = $field;
        } else {
            throw new \InvalidArgumentException('Invalid sort field value.');
        }

        // For fluent interface
        return $this;
    }

    /**
     * Gets sorting order
     *
     * @return int
     */
    public function getSortOrder()
    {
        return $this->order;
    }

    /**
     * Sets sorting order
     *
     * @param int $order Sort order. Supported values: SORT_ASC and SORT_DESC
     * @return self Returns self for Fluent interface
     * @throws \InvalidArgumentException Throws exception for unsupported value
     */
    public function setSortOrder($order)
    {
        if (in_array($order, [SORT_ASC, SORT_DESC])) {
            $this->order = $order;
        } else {
            throw new \InvalidArgumentException('Invalid sort order.');
        }

        // For fluent interface
        return $this;
    }

    /**
     * Sort
     * Given customer records are sorted per field and order
     *
     * @param array $array
     * @return array
     */
    public function Sort(array $array) : array
    {
        $on = $this->getSortField();
        $sortFx = $this->getSortOrder() == SORT_ASC ? 'asort' : 'arsort';
        $newArray = array();
        $sortableArray = array();
    
        if (count($array) > 0) {
            // Compile list to sort
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortableArray[$k] = $v2;
                        }
                    }
                } else {
                    throw new \InvalidArgumentException('Expected an array representing customer record but given: '.var_export($v, true));
                }
            }

            // Apply sort function
            $sortFx($sortableArray);

            // Re-arrange given $array elements in sorted order ($sortableArray)
            foreach ($sortableArray as $k => $v) {
                $newArray[$k] = $array[$k];
            }
        }
    
        return $newArray;
    }
}
