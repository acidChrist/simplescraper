<?php

namespace App\Tests\VitecScrapper;


use App\Service\VitecScrapper\Value;
use PHPUnit\Framework\TestCase;

class ValueTest extends TestCase
{
    public function testValue()
    {
        $value = new Value('name', 'value');
        $this->assertSame(['name'=>'name', 'value'=>'value'], $value->getValue());
    }
}