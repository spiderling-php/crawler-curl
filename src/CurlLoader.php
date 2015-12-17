<?php

namespace SP\Driver;

use SP\Crawler\LoaderInterface;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class CurlLoader implements LoaderInterface
{
    const USER_AGENT = 'Spiderling Simple Driver';

    /**
     * @var \Psr\Http\Message\UriInterface;
     */
    private $currentUri;

    private $base;

    /**
     * @param  array  $row
     * @return string
     */
    public function headerRow(array $row)
    {
        return join('; ', $row);
    }

    public function setBase(UriInterface $uri)
    {
        $base = (string) $uri->withPath('')->withQuery('')->withFragment('');

        if ($base and $base !== $this->base) {
            $this->base = $base;
        }
    }

    public function getBase()
    {
        return $this->base;
    }

    /**
     * @param  RequestInterface $request
     */
    public function send(RequestInterface $request)
    {
        $this->currentUri = $request->getUri();
        $this->setBase($this->currentUri);

        if (empty($this->currentUri->getHost())) {
            $this->currentUri = new Uri($this->getBase().$this->currentUri);
        }

        $curl = curl_init();

        $headers = array_map(
            [$this, 'headerRow'],
            $request->getHeaders()
        );

        curl_setopt_array($curl, [
            CURLOPT_URL => (string) $this->currentUri,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $request->getMethod(),
            CURLOPT_USERAGENT => CurlLoader::USER_AGENT,
            CURLOPT_HEADER => true,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        if ($request->getBody()->getSize()) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, (string) $request->getBody());
        }

        $response = curl_exec($curl);

        curl_error($curl);

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
