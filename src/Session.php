<?php

namespace SP\CurlDriver;

use SP\Spiderling\CrawlerSession;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Session extends CrawlerSession
{
    public function __construct(Crawler $crawler = null)
    {
        parent::__construct($crawler ?: new Crawler());
    }
}
