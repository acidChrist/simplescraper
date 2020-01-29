<?php

namespace App\Tests\Service\VitecScrapper;


use App\Service\VitecScrapper\Product;
use App\Service\VitecScrapper\Value;
use App\Service\VitecScrapper\Scrappable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

class ProductTest extends TestCase
{
    public function packageProvider()
    {
        $package = '<div class="package featured center"></div>';
        return [[$package]];

    }

    /**
     * @dataProvider packageProvider
     */
    public function testScrape($package)
    {
        $crawler = new Crawler($package);
        $product = new Product($crawler);

        $className = get_class(new class implements Scrappable {
            public function scrape(): Value {
                return new Value('test', 'test content');
            }
        });

        $product->addScrapper($className);

        $value = $product->scrape();

        $this->assertInstanceOf(Value::class, $value);

        $result = $value->getValue();

        $this->assertSame('product_options', $result['name']);
        $this->assertInstanceOf(\ArrayIterator::class, $result['value']);
    }
}