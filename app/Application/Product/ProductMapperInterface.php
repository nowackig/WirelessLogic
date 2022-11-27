<?php

declare(strict_types=1);

namespace WirelessLogic\Application\Product;

interface ProductMapperInterface
{
    public function map(array $products): ProductCollection;
}
