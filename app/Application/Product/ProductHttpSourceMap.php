<?php

namespace WirelessLogic\Application\Product;

use WirelessLogic\Application\Parsers\ProductHttpSourceMapInterface;

enum ProductHttpSourceMap: string implements ProductHttpSourceMapInterface
{
    case TEST_PAGE = 'https://wltest.dns-systems.net';

    public function productCssClass(): string
    {
        return match ($this) {
            self::TEST_PAGE => 'package',
        };
    }
}
