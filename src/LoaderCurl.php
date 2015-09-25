<?php

namespace SP\CrawlerCurl;

use SP\Crawler\LoaderInterface;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class LoaderCurl implements LoaderInterface
{
    const USER_AGENT = 'Spiderling Simple Driver';

    /**
     * @var \Psr\Http\Message\UriInterface;
     */
    private $currentUri;

    /**
     * @param  RequestInterface $request
     */
    public function send(RequestInterface $request)
    {
        $this->currentUri = $request->getUri();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => (string) $this->currentUri,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $request->getMethod(),
            CURLOPT_USERAGENT => LoaderCurl::USER_AGENT,
            CURLOPT_HEADER => true,
            CURLOPT_HTTPHEADER => array_map(
                function($row) { return join('; ', $row); },
                $request->getHeaders()
            ),
        ]);

        if ($request->getBody()) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, (string) $request->getBody());
        }

        $response = curl_exec($curl);

        $this->currentUri = new Uri(curl_getinfo($curl, CURLINFO_EFFECTIVE_URL));

        return \GuzzleHttp\Psr7\parse_response($response);
    }

    /**
     * @return \Psr\Http\Message\UriInterface
     */
    public function getCurrentUri()
    {
        return $this->currentUri;
    }
}
