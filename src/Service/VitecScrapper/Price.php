<?php

namespace App\Service\VitecScrapper;


use Symfony\Component\DomCrawler\Crawler;

/**
 * Class scrapes price from a product option
 *
 * @package App\Service\VitecScrapper
 */
class Price implements Scrappable
{
    const NAME = 'price';

    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * Price constructor.
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * Scrapes price and returns it a value object
     *
     * @return Value
     */
    public function scrape(): Value
    {
        $price = $this->crawler->filter('.package-price .price-big');

        if ($price->count() > 0) {
            preg_match('/^(.*?)([\d]+(?:\.[\d]{2}))$/',$price->text(), $data);

            if (isset($data[2])) {
                return new Value(self::NAME, $data[2]);
            }
        }

        return new Value(self::NAME, null);
    }
}