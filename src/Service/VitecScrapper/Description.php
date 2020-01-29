<?php

namespace App\Service\VitecScrapper;


use Symfony\Component\DomCrawler\Crawler;

/**
 * Class scrapes description from a product option
 *
 * @package App\Service\VitecScrapper
 */
class Description implements Scrappable
{
    const NAME = 'description';

    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * Description constructor.
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * Scrapes description and returns it a value object
     *
     * @return Value
     */
    public function scrape(): Value
    {
        $description = $this->crawler->filter('.package-name');

        $value = null;
        if ($description->count() > 0) {
            $value = str_replace('<br>', "\n", $description->html());
        }

        return new Value(self::NAME, $value);
    }
}