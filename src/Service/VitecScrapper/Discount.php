<?php

namespace App\Service\VitecScrapper;


use Symfony\Component\DomCrawler\Crawler;

/**
 * Class scrapes discount from a product option
 *
 * @package App\Service\VitecScrapper
 */
class Discount implements Scrappable
{
    const NAME = 'discount';

    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * Discount constructor.
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * Scrapes discount and returns it a value object
     *
     * @return Value
     */
    public function scrape(): Value
    {
        $discount = $this->crawler->filter('.package-price p');

        return new Value(self::NAME, $discount->count()?$discount->text():null);
    }

}