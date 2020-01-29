<?php

namespace App\Service\VitecScrapper;


/**
 * Class sort two dimentions arrays by a field
 *
 * @package App\Service\VitecScrapper
 */
class DataSort
{
    const DESC = 'asc';

    const ASC = 'desc';

    /**
     * @var
     */
    protected $field;

    /**
     * @var
     */
    protected $direction;

    /**
     * DataSort constructor.
     * @param $field
     * @param $direction
     */
    public function __construct($field, $direction)
    {
        $this->field = $field;

        $this->direction = $direction;
    }

    /**
     * Method return sorted array
     *
     * @param \ArrayIterator $items
     * @return \ArrayIterator
     */
    public function sort(\ArrayIterator $items): \ArrayIterator
    {
        $data = iterator_to_array($items);

        usort($data, function ($a, $b) {
            if ($this->direction == self::ASC) {
                return $a[$this->field] <=> $b[$this->field];
            } else if ($this->direction == self::DESC) {
                return $b[$this->field] <=> $a[$this->field];
            }
        });

        return new \ArrayIterator($data);
    }
}