<?php

declare(strict_types=1);

namespace WirelessLogic\Application\Queries;

interface WebsiteQueryInterface
{
    public function get(string $uri): string;
}
