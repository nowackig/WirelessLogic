<?php

declare(strict_types=1);

namespace WirelessLogic\Application\Factories;

use WirelessLogic\Application\Enums\TimeMapEnum;
use WirelessLogic\Application\Product\Product;
use WirelessLogic\Application\Product\ProductCollection;

class ProductJsonResponseFactory
{
    public static function create(ProductCollection $products): string
    {
        $response = array_map(
            fn (Product $product) => [
                'title' => $product->title,
                'description' => sprintf(
                    '%s %s. %s',
                    $product->name,
                    $product->description,
                    $product->data
                ),
                'price' => sprintf(
                    '%s%d/%s (%s)',
                    $product->currency,
                    $product->price,
                    TimeMapEnum::byMonthsNumber($product->monthCount)->value,
                    $product->netGross
                ),
                'discount' => $product->discount ?? null,
            ],
            $products->toArray()
        );

        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
