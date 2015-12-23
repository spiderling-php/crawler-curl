<?php

namespace SP\CurlDriver;

use SP\Crawler\Crawler as BaseCrawler;
use DOMDocument;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Crawler extends BaseCrawler
{
    /**
     * @param DOMDocument|null $document
     */
    public function __construct(DOMDocument $document = null)
    {
        if (null === $document) {
            $document = new DOMDocument('1.0', 'UTF-8');
        }

        parent::__construct(new Loader(), $document);
    }
}
