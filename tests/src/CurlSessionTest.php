<?php

namespace SP\Driver\Test;

use PHPUnit_Framework_TestCase;
use SP\Driver\CurlSession;

/**
 * @coversDefaultClass SP\Driver\CurlSession
 */
class CurlSessionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $browser = $this
            ->getMockBuilder('SP\Driver\CurlCrawler')
            ->disableOriginalConstructor()
            ->getMock();

        $session = new CurlSession($browser);

        $this->assertInstanceOf('SP\Spiderling\CrawlerInterface', $session->getCrawler());

        $this->assertSame($browser, $session->getCrawler());
    }

    /**
     * @covers ::__construct
     */
    public function testConstructDefault()
    {
        $session = new CurlSession();

        $this->assertInstanceOf('SP\Driver\CurlCrawler', $session->getCrawler());
    }
}
