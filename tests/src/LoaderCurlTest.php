<?php

namespace SP\CrawlerCurl\Test;

use SP\CrawlerCurl\LoaderCurl;
use PHPUnit_Framework_TestCase;
use GuzzleHttp\Tests\Server;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * @coversDefaultClass SP\CrawlerCurl\LoaderCurl
 */
class LoaderCurlTest extends PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        Server::start();
    }

    public static function tearDownAfterClass()
    {
        Server::stop();
    }

    public function tearDown()
    {
        Server::flush();
    }

    /**
     * @covers ::send
     * @covers ::getCurrentUri
     */
    public function testSend()
    {
        Server::enqueue([
            new Response(200, [], 'test response')
        ]);

        $loader = new LoaderCurl();
        $request = new Request('GET', Server::$url);
        $response = $loader->send($request);

        $this->assertEquals('test response', $response->getBody());

        $this->assertEquals('http://127.0.0.1:8126/', $loader->getCurrentUri());
    }

    /**
     * @covers ::send
     * @covers ::getCurrentUri
     */
    public function testSendPost()
    {
        Server::enqueue([
            new Response(200, [], 'other response!')
        ]);

        $loader = new LoaderCurl();
        $request = new Request(
            'POST',
            Server::$url,
            ['Content-Type' => 'application/x-www-form-urlencoded'],
            'name=test&gender=female'
        );

        $response = $loader->send($request);

        $this->assertEquals('other response!', $response->getBody());

        $this->assertEquals('http://127.0.0.1:8126/', $loader->getCurrentUri());
    }
}
