<?php

namespace SP\Driver;

use SP\Spiderling\CrawlerSession;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class CurlSession extends CrawlerSession
{
    public function __construct(CurlCrawler $crawler = null)
    {
        parent::__construct($crawler ?: new CurlCrawler());
    }
}
