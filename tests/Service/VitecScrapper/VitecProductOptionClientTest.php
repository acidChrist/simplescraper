<?php

namespace App\Tests\Service;


use App\Service\VitecScrapper\VitecClient;
use App\Service\VitecScrapper\VitecProductOptionClient;
use Goutte\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class VitecProductOptionClientTest extends TestCase
{
    public function packagesProvider()
    {
        $package =<<<EOT
<div class="package featured center">
    <div class="header dark-bg">
        <h3>Option 1</h3>
    </div>
    <div class="package-features">
        <ul>
            <li>
                <div class="package-name">description</div>
            </li>
            <li>
                <div class="package-price">
                    <span class="price-big">£6.00</span>
                </div>
            </li>
            <li>
                <div class="package-data">Package data</div>
            </li>
        </ul>
    </div>
</div>
EOT;

        return [[
            $package
        ]];
    }

    /**
     * @dataProvider packagesProvider
     */
    public function testOptions($html)
    {
        $mockResponse = new MockResponse($html);
        $httpClientMock = new MockHttpClient($mockResponse);
        $goutteClient = new Client($httpClientMock);
        $vitecCrawler  = new VitecProductOptionClient('', $goutteClient);
        $this->assertInstanceOf(\Iterator::class, $vitecCrawler->getAll());
    }
}