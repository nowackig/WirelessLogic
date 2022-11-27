<?php

declare(strict_types=1);

namespace WirelessLogic\Infrastructure\Http\Mappers;

use WirelessLogic\Application\Enums\TimeMapEnum;
use WirelessLogic\Application\Product\Product;
use WirelessLogic\Application\Product\ProductCollection;
use WirelessLogic\Application\Product\ProductMapperInterface;

class ProductCssClassMapper implements ProductMapperInterface
{
    public function map(array $products): ProductCollection
    {
        return new ProductCollection(array_map(
            callback: function (array $product) {
                $priceMapping = array_merge(...array_map(
                    function (?string $value, string $name) {
                        return [$name => $value];
                    },
                    is_array($product['price-big']) ? $product['price-big'] : [$product['price-big']],
                    ['price', 'discount']
                ));

                extract($this->priceBig($priceMapping['price']));
                extract($this->packagePrice($product['package-price']));

                // TODO Use product factory
                return new Product(
                    title: $product['header'],
                    name: $product['package-name'],
                    description: $product['package-description'],
                    price: $price,
                    currency: $currency,
                    netGross: $netGross,
                    monthCount: (TimeMapEnum::from($timeContext))->months(),
                    data: $product['package-data'],
                    discount: $priceMapping['discount'] ?: null
                );
            },
            array: $products
        ));
    }

    private function packagePrice(string $data): array
    {
        $matches = null;
        preg_match(pattern: '/\\((?<netGross>[^\\)]+)\\)Per (?<timeContext>[\\w\\s]+)/', subject: $data, matches: $matches);

        return array_map('trim', (array) array_filter(
            (array) $matches,
            fn ($key) => !is_numeric($key),
            ARRAY_FILTER_USE_KEY
        ));
    }

    private function priceBig(string $data): array
    {
        $matches = null;
        preg_match('/^(?>\\s)?(?<currency>[^\\d\\s]+)(?>\\s)?(?<price>[\\d\\.]+)/', $data, $matches);

        return array_filter(
            $matches,
            fn ($key) => !is_numeric($key),
            ARRAY_FILTER_USE_KEY
        );
    }
}
