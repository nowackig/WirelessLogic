<?php

declare(strict_types=1);

namespace WirelessLogic\Infrastructure\Http\Queries;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use WirelessLogic\Application\Queries\WebsiteQueryInterface;

class WebsiteQuery implements WebsiteQueryInterface
{
    public function __construct(private Client $client)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $uri): string
    {
        $response = $this->client->request('GET', $uri);

        return $response->getBody()->getContents();
    }
}
