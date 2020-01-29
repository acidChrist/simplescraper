<?php

namespace App\Service\VitecScrapper;

/**
 * Client interface
 *
 * @package App\Service\VitecScrapper
 */
interface ClientInterface
{
    public function getAll():? \ArrayIterator;
}