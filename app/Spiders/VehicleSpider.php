<?php

namespace App\Spiders;

use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Request;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;

class VehicleSpider extends BasicSpider
{
    public array $startUrls = [
        'https://afyal.com'
    ];

    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
    ];

    public array $spiderMiddleware = [
        //
    ];

    public array $itemProcessors = [
        //
    ];

    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class,
    ];

    public int $concurrency = 2;

    public int $requestDelay = 1;

    protected function initialRequests(): array
    {
        $data = ['vin' => 'TMAJ28139HJ389639'];

        return [ new Request('https://afyal.com/getbrand_data.php', 'POST', [$this, 'parsePostResponse'], compact('data')) ];
    }

    public function parse(Response $response): \Generator
    {
        dd('parse');
    }

    /**
     * @return Generator<ParseResult>
     */
    public function parsePostResponse(Response $response): \Generator
    {
        dd('parse');
        $statusCode = $response->getStatus();
        $body = $response->getBody()->__toString();

        // Example: Log the response
        dd("POST Request Status Code: " . $statusCode . "\n");
        dd("POST Request Response Body: " . $body . "\n");
    }
}
