<?php

declare(strict_types=1);

namespace Tests\Generators;

use WirelessLogic\Application\Enums\TimeMapEnum;
use WirelessLogic\Application\Product\Product;
use WirelessLogic\Application\Product\ProductCollection;

class ResponseGenerator
{
    /**
     * @param Product[] $products
     * @return string
     */
    public static function websiteResponse(array $products): string
    {
        $response = <<<'EOF'
<div class="pricing-table">
            <div class="row-subscriptions" style="margin-bottom:40px;">

EOF;

        foreach ($products as $product) {
            $response .= sprintf('<div class="col-xs-4">%s</div> <!-- /END PACKAGE -->', self::productHttpResponse($product));
        }

        $response .= <<<'EOF'
</div> <!-- /END ROW -->
        </div>
EOF;

        return $response;
    }

    private static function productHttpResponse(Product $product): string
    {
        $timeContext = TimeMapEnum::byMonthsNumber($product->monthCount)->value;

        return <<<EOF
                <div class="package featured-right">
                    <div class="header">
                        <h3>{$product->title}</h3>
                    </div>
                    <div class="package-features">
                        <ul>
                            <li>
                                <div class="package-name">{$product->name}</div>
                            </li>
                            <li>
                                <div class="package-description">{$product->description}</div>
                            </li>
                            <li>
                                <div class="package-price">
                                    <span class="price-big">{$product->currency}{$product->price}</span>
                                    <br>({$product->netGross})<br>Per {$timeContext}
                                    <p style="color: red">{$product->discount}</p>
                                </div>
                            </li>
                            <li>
                                <div class="package-data">{$product->data}</div>
                            </li>
                        </ul>
                        <div class="bottom-row">
                            <a class="btn btn-primary main-action-button" href="https://wltest.dns-systems.net/#" role="button">Choose</a>
                        </div>
                    </div>
                </div>
EOF;
    }

    public static function parsedProductsResponse(array $products): array
    {
        $response = [];
        foreach ($products as $product) {
            $response[] = self::parsedProductResponse($product);
        }

        return $response;
    }

    private static function parsedProductResponse(Product $product):array
    {
        return [
            'header' => $product->title,
            'package-name' => $product->name,
            'package-description' => $product->description,
            'package-price' => sprintf('(%s)Per %s', $product->netGross, TimeMapEnum::byMonthsNumber($product->monthCount)->value),
            'price-big' => [
                sprintf('%s%.2f', $product->currency, $product->price),
                $product->discount,
            ],
            'package-data' => $product->data,
        ];
    }

    public static function jsonResponse(ProductCollection $products): string
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
