<?php

declare(strict_types=1);

namespace WirelessLogic\Application\Product;

use Illuminate\Support\Collection;
use Throwable;

class ProductCollection extends Collection
{
    /**
     * @param Product[] $products
     */
    public function __construct(array $products = [])
    {
        try {
            array_filter($products, fn (Product $product) => true);
            parent::__construct($products);
        } catch(Throwable $throwable) {
            exit(print_r($products, true));
        }
    }
}
