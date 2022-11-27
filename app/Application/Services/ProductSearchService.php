<?php

declare(strict_types=1);

namespace WirelessLogic\Application\Services;

use WirelessLogic\Application\Parsers\ProductParserInterface;
use WirelessLogic\Application\Product\ProductCollection;
use WirelessLogic\Application\Product\ProductHttpSourceMap;
use WirelessLogic\Application\Product\ProductMapperInterface;
use WirelessLogic\Application\Queries\WebsiteQueryInterface;

class ProductSearchService
{
    public function __construct(
        private readonly WebsiteQueryInterface $websiteQuery,
        private readonly ProductParserInterface $productParser,
        private readonly ProductMapperInterface $productMapper
    ) {
    }

    public function search(ProductHttpSourceMap $productSourceMap): ProductCollection
    {
        $websiteContent = $this->websiteQuery->get($productSourceMap->value);
        $parsedWebContent = $this->productParser->parse($websiteContent, $productSourceMap);

        return $this->productMapper->map($parsedWebContent);
    }
}
