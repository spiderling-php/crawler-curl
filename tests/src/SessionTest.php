<?php

namespace SP\CurlDriver\Test;

use PHPUnit_Framework_TestCase;
use SP\CurlDriver\Session;

/**
 * @coversDefaultClass SP\CurlDriver\Session
 */
class SessionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $browser = $this
            ->getMockBuilder('SP\CurlDriver\Crawler')
            ->disableOriginalConstructor()
            ->getMock();

        $session = new Session($browser);

        $this->assertInstanceOf('SP\Spiderling\CrawlerInterface', $session->getCrawler());

        $this->assertSame($browser, $session->getCrawler());
    }

    /**
     * @covers ::__construct
     */
    public function testConstructDefault()
    {
        $session = new Session();

        $this->assertInstanceOf('SP\CurlDriver\Crawler', $session->getCrawler());
    }
}
