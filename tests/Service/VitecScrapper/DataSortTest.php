<?php

namespace App\Tests\VitecScrapper;


use App\Service\VitecScrapper\DataSort;
use PHPUnit\Framework\TestCase;

class DataSortTest extends TestCase
{
    public function testAscSort()
    {
        $dataSort = new DataSort('column', DataSort::ASC);
        $result = $dataSort->sort(new \ArrayIterator([['column'=>2],['column'=>1]]));

        $this->assertEquals(new \ArrayIterator([['column'=>1],['column'=>2]]), $result);
    }

    public function testDescSort()
    {
        $dataSort = new DataSort('column', DataSort::DESC);
        $result = $dataSort->sort(new \ArrayIterator([['column'=>1],['column'=>2]]));

        $this->assertEquals(new \ArrayIterator([['column'=>2],['column'=>1]]), $result);
    }
}