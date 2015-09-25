<?php

namespace SP\CrawlerCurl;

use SP\Crawler\Crawler;
use DOMDocument;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class CrawlerCurl extends Crawler
{
    /**
     * @param DOMDocument|null $document
     */
    public function __construct(DOMDocument $document = null)
    {
        if (null === $document) {
            $document = new DOMDocument('1.0', 'UTF-8');
        }

        parent::__construct(new LoaderCurl(), $document);
    }
}
