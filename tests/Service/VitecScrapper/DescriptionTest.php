<?php

namespace App\Tests\VitecScrapper;


use App\Service\VitecScrapper\Description;
use App\Service\VitecScrapper\Value;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

class DescriptionTest extends TestCase
{
    public function packagesProvider()
    {
        $package = <<<EOT
    <div class="package-features">
        <ul>
            <li>
                <div class="package-name">Up to 40 minutes talk time per month<br />including 20 SMS<br/>(5p / minute and 4p / SMS thereafter)</div>
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
        $description = new Description($crawler);
        $value = $description->scrape();

        $this->assertInstanceOf(Value::class, $value);

        $result = $value->getValue();

        $this->assertSame("Up to 40 minutes talk time per month\nincluding 20 SMS\n(5p / minute and 4p / SMS thereafter)", $result['value']);
        $this->assertSame('description', $result['name']);
    }
}