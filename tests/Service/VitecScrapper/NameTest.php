<?php

namespace App\Tests\VitecScrapper;


use App\Service\VitecScrapper\Name;
use App\Service\VitecScrapper\Value;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

class NameTest extends TestCase
{
    public function packagesProvider()
    {
        $package = <<<EOT
<div class="package featured center">
    <div class="header dark-bg">
        <h3>Option 2000 Mins</h3>
    </div>
</div>
EOT;

        return [[
            $package
        ]];
    }

    /**
     * @dataProvider packagesProvider
     */
    public function testScrape($html)
    {
        $crawler = new Crawler($html);
        $price = new Name($crawler);
        $value = $price->scrape();

        $this->assertInstanceOf(Value::class, $value);

        $result = $value->getValue();

        $this->assertSame('Option 2000 Mins', $result['value']);
        $this->assertSame('option_title', $result['name']);
    }
}