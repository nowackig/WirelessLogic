<?php

namespace WirelessLogic\App\Providers;

use Illuminate\Support\ServiceProvider;
use WirelessLogic\Application\Parsers\ProductHttpSourceMapInterface;
use WirelessLogic\Application\Parsers\ProductParserInterface;
use WirelessLogic\Application\Product\ProductFactoryInterface;
use WirelessLogic\Application\Product\ProductHttpSourceMap;
use WirelessLogic\Application\Product\ProductMapperInterface;
use WirelessLogic\Application\Queries\WebsiteQueryInterface;
use WirelessLogic\Infrastructure\Http\Factories\ProductFactory;
use WirelessLogic\Infrastructure\Http\Mappers\ProductCssClassMapper;
use WirelessLogic\Infrastructure\Http\Parsers\ProductParser;
use WirelessLogic\Infrastructure\Http\Queries\WebsiteQuery;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        WebsiteQueryInterface::class => WebsiteQuery::class,
        ProductFactoryInterface::class => ProductFactory::class,
        ProductParserInterface::class => ProductParser::class,
        ProductMapperInterface::class => ProductCssClassMapper::class,
        ProductHttpSourceMapInterface::class => ProductHttpSourceMap::class,
    ];
}
