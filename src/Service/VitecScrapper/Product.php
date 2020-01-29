<?php

namespace App\Service\VitecScrapper;


use Symfony\Component\DomCrawler\Crawler;

/**
 * Class is product options scrapper
 *
 * @package App\Service\VitecScrapper
 */
class Product implements Scrappable
{
    const NAME = 'product_options';

    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * @var \ArrayIterator
     */
    protected $scrappers;

    /**
     * @var
     */
    protected $html;

    /**
     * Product constructor.
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;

        $this->scrappers = new \ArrayIterator();
    }

    /**
     * Adding scrappers objects names
     *
     * @param $scrapper
     */
    public function addScrapper(string $scrapper)
    {
        $this->scrappers->append($scrapper);
    }

    /**
     * Process package by all scrappers
     *
     * @param $item
     * @return \ArrayIterator
     */
    protected function process($item): \ArrayIterator
    {
        $items = new \ArrayIterator();
        foreach ( $this->scrappers as $scrapper )
        {
            $crawler = new Crawler($item);
            $instance = new $scrapper($crawler);
            $items->append($instance->scrape());
        }

        return $items;
    }

    /**
     * Scrapes product
     *
     * @return Value
     */
    public function scrape(): Value
    {
        $items = $this->crawler->filter('.package');
        $options = new \ArrayIterator();
        foreach ($items as $item) {
            $options->append($this->process($item));
        }

        return new Value(self::NAME, $options);
    }
}