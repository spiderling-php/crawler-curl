<?php

namespace SP\CurlDriver;

use SP\Crawler\LoaderInterface;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Loader implements LoaderInterface
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
    public function getConvertedHeaders(array $headers)
    {
        $converted = [];

        foreach ($headers as $name => $value) {
            $converted []= $name.': '.join('; ', (array) $value);
        }

        return $converted;
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
     * @param  ServerRequestInterface $request
     */
    public function send(ServerRequestInterface $request)
    {
        $this->currentUri = $request->getUri();
        $this->setBase($this->currentUri);

        if (empty($this->currentUri->getHost())) {
            $this->currentUri = new Uri($this->getBase().$this->currentUri);
        }

        $curl = curl_init();

        $options = [
            CURLOPT_URL => (string) $this->currentUri,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $request->getMethod(),
            CURLOPT_USERAGENT => Loader::USER_AGENT,
            CURLOPT_HEADER => true,
            CURLOPT_HTTPHEADER => $this->getConvertedHeaders($request->getHeaders()),
        ];

        if ($request->getBody()->getSize()) {
            $options[CURLOPT_POSTFIELDS] = (string) $request->getBody();
        }

        curl_setopt_array($curl, $options);

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
