<?php

namespace WirelessLogic\Application\Product;

class Product
{
    public function __construct(
        readonly public string $title,
        readonly public string $name,
        readonly public string $description,
        readonly public string $price,
        readonly public string $currency,
        readonly public string $netGross,
        readonly public int $monthCount,
        readonly public string $data,
        readonly public ?string $discount,
    ) {
    }
}
