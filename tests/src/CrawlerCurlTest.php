<?php

namespace SP\CrawlerCurl\Test;

use SP\CrawlerCurl\CrawlerCurl;
use PHPUnit_Framework_TestCase;
use DOMDocument;

/**
 * @coversDefaultClass SP\CrawlerCurl\CrawlerCurl
 */
class CrawlerCurlTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $document = new DOMDocument();

        $crawler = new CrawlerCurl($document);

        $this->assertInstanceOf('SP\CrawlerCurl\LoaderCurl', $crawler->getLoader());
        $this->assertSame($document, $crawler->getDocument());

        $crawler = new CrawlerCurl();

        $this->assertInstanceOf('SP\CrawlerCurl\LoaderCurl', $crawler->getLoader());
        $this->assertInstanceOf('DOMDocument', $crawler->getDocument());
    }
}
