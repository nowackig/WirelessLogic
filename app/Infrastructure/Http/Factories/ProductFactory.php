<?php

declare(strict_types=1);

namespace WirelessLogic\Infrastructure\Http\Factories;

use WirelessLogic\Application\Product\Product;
use WirelessLogic\Application\Product\ProductFactoryInterface;

class ProductFactory implements ProductFactoryInterface
{
    // TODO Replace the array type with something more specific
    public function create(array $data): Product
    {
        return new Product(
            title: $data['title'],
            name: $data['name'],
            description: $data['description'],
            price: $data['price'],
            currency: $data['currency'],
            netGross: $data['netGross'],
            monthCount: $data['priceTimeContext'],
            data: $data['data'],
            discount: $data['discount']
        );
    }
}
