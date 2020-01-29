<?php

namespace App\Service\VitecScrapper;

/**
 * Interface implementing by scrappers
 *
 * @package App\Service\VitecScrapper
 */
interface Scrappable
{
    public function scrape(): Value;
}