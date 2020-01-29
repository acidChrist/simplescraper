<?php

namespace App\Service\VitecScrapper;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class is a Vitec client for scrapping product options
 *
 * @package App\Service\VitecScrapper
 */
class VitecProductOptionClient implements ClientInterface
{
    /**
     * @var
     */
    protected $url;

    /**
     * @var Client|null
     */
    protected $client;

    /**
     * VitecProductOptionClient constructor.
     *
     * @param $vitecProductUrl
     * @param Client|null $client
     */
    public function __construct($vitecProductUrl, Client $client = null)
    {
        $this->url = $vitecProductUrl;

        if ($client === null) {
            $this->client = new Client();
        } else {
            $this->client = $client;
        }
    }

    /**
     * Sends request to a resource and return Crawler
     *
     * @return Crawler
     */
    protected function getProductCrawler(): Crawler
    {
        return $this->client->request('GET', $this->url);
    }

    /**
     * Factory method initiated Product scrapper
     * @return Product
     */
    protected function getProductScrapper(): Product
    {
        $productScrapper = new Product($this->getProductCrawler());

        $productScrapper->addScrapper(Name::class);
        $productScrapper->addScrapper(Price::class);
        $productScrapper->addScrapper(Discount::class);
        $productScrapper->addScrapper(Description::class);

        return $productScrapper;
    }

    /**
     * Transform advanced multidimentional array into simple two levels array
     *
     * @param $rows
     * @return \ArrayIterator
     */
    protected function simplify(\ArrayIterator $rows): \ArrayIterator
    {
        $collection = new \ArrayIterator();

        foreach ($rows as $row) {
            if ($row instanceof \ArrayIterator) {
                $item = [];
                foreach ($row as $column) {
                    $value = $column->getValue();
                    $item[$value['name']] = $value['value'];
                }

                $collection->append($item);
            }
        }

        return $collection;
    }

    /**
     * Returns list of options
     *
     * @return \ArrayIterator|null
     */
    public function getAll():? \ArrayIterator
    {
        $scrapper = $this->getProductScrapper();

        $response = $scrapper->scrape();

        if ( $response instanceof Value) {
            $result = $response->getValue();

            if ($result['value']->count() > 0) {
                return $this->simplify($result['value']);
            }
        }

        return null;
    }
}