<?php

namespace SP\CurlDriver\Test;

use SP\DriverTest\CrawlerDriverTest;
use SP\CurlDriver\Crawler;

/**
 * @covers SP\CurlDriver\Loader
 */
class IntegrationTest extends CrawlerDriverTest
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        usleep(50000);

        self::setDriver(new Crawler());
    }
}
