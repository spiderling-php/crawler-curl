<?php

namespace SP\Driver\Test;

use SP\Driver\CurlCrawler;
use PHPUnit_Framework_TestCase;
use DOMDocument;

/**
 * @coversDefaultClass SP\Driver\CurlCrawler
 */
class CurlCrawlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $document = new DOMDocument();

        $crawler = new CurlCrawler($document);

        $this->assertInstanceOf('SP\Driver\CurlLoader', $crawler->getLoader());
        $this->assertSame($document, $crawler->getDocument());

        $crawler = new CurlCrawler();

        $this->assertInstanceOf('SP\Driver\CurlLoader', $crawler->getLoader());
        $this->assertInstanceOf('DOMDocument', $crawler->getDocument());
    }
}
