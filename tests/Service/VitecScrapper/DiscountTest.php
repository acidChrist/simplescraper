<?php

namespace App\Tests\VitecScrapper;

use App\Service\VitecScrapper\Discount;
use App\Service\VitecScrapper\Value;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

class DiscountTest extends TestCase
{
    public function packagesProvider()
    {
        $package = <<<EOT
    <div class="package-features">
        <ul>
            <li>
                <div class="package-price">
                    <span class="price-big">£6.00</span><br />(inc. VAT)<br />Per Month
                    <p style="color: red">Save £12 on the monthly price</p>
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
        $discount = new Discount($crawler);
        $value = $discount->scrape();

        $this->assertInstanceOf(Value::class, $value);

        $result = $value->getValue();

        $this->assertSame('Save £12 on the monthly price', $result['value']);
        $this->assertSame('discount', $result['name']);
    }
}