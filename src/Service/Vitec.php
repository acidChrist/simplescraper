<?php

namespace App\Service;

use App\Service\VitecScrapper\DataSort;
use App\Service\VitecScrapper\VitecProductOptionClient;

/**
 * Vitec class manage data comming from vitec client.
 *
 * @package App\Service
 */
class Vitec
{
    /**
     * @var VitecProductOptionClient
     */
    protected $productOptions;

    /**
     * Vitec constructor.
     * @param VitecProductOptionClient $productOptions
     */
    public function __construct(VitecProductOptionClient $productOptions)
    {
        $this->productOptions = $productOptions;
    }

    /**
     * @param $items
     * @param $column
     * @param $direction
     * @return \ArrayIterator
     */
    protected function sort($items, $column, $direction)
    {
        $dataSort = new DataSort($column, $direction);
        return $dataSort->sort($items);
    }

    /**
     * @return \ArrayIterator|null
     */
    public function getProductOptions():? \ArrayIterator
    {
        $options = $this->productOptions->getAll();

        if ($options) {
            return $this->sort($options, 'price', DataSort::DESC);
        }

        return null;
    }
}