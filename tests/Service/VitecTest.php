<?php

namespace App\Tests\Service;


use App\Service\Vitec;
use App\Service\VitecScrapper\VitecProductOptionClient;
use PHPUnit\Framework\TestCase;

class VitecTest extends TestCase
{
    public function testProductOptions()
    {
        $vitecOptionsClient = $this->getMockBuilder(VitecProductOptionClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $vitecOptionsClient
            ->method('getAll')
            ->willReturn(new \ArrayIterator());

        $vitec = new Vitec($vitecOptionsClient);
        $this->assertInstanceOf(\ArrayIterator::class, $vitec->getProductOptions());
    }
}