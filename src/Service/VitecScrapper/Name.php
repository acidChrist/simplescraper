<?php

namespace App\Service\VitecScrapper;


use Symfony\Component\DomCrawler\Crawler;

/**
 * Class scrapes name from a product option
 *
 * @package App\Service\VitecScrapper
 */
class Name implements Scrappable
{
    const NAME = 'option_title';

    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * Name constructor.
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * Scrapes option name and returns it a value object
     * @return Value
     */
    public function scrape(): Value
    {
        $name = $this->crawler->filter('.header h3');

        return new Value(self::NAME, $name->count()?$name->text():null);
    }
}