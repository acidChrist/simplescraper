<?php

namespace App\Tests\VitecScrapper;


use App\Service\VitecScrapper\Price;
use App\Service\VitecScrapper\Value;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

class PriceTest extends TestCase
{
    public function packagesProvider()
    {
        $package = <<<EOT
    <div class="package-features">
        <ul>
            <li>
                <div class="package-price">
                    <span class="price-big">£6.00</span><br />(inc. VAT)<br />Per Month
                </div>
            </li>
        </ul>
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
        $price = new Price($crawler);
        $value = $price->scrape();

        $this->assertInstanceOf(Value::class, $value);

        $result = $value->getValue();

        $this->assertSame('6.00', $result['value']);
        $this->assertSame('price', $result['name']);
    }
}