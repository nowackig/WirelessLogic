<?php

declare(strict_types=1);

namespace Tests\Generators;

use Exception;
use Illuminate\Foundation\Testing\WithFaker;
use WirelessLogic\Application\Enums\TimeMapEnum;
use WirelessLogic\Application\Product\Product;

class FakerGenerator
{
    use WithFaker;

    public function __construct()
    {
        $this->faker = $this->faker('en');
    }

    /**
     * @throws Exception
     */
    public function products(int $count = 1): array
    {
        $count >= 1 ?: throw new Exception(sprintf('The number of products to create must be equal to or greater than 1. %ds received.', $count));
        $products = [];
        $currency = $this->faker->currencyCode;
        $price = preg_replace('/^[0]*(?=(0|\\d).)/', '', $this->faker->numerify('###.##'));
        while ($count >= 1) {
            $products[] = new Product(
                title: 'Title ' . $this->faker->sentence(5),
                name: 'Name ' . $this->faker->words(3, true),
                description: 'Description ' . $this->faker->paragraph,
                price: $price,
                currency: $currency,
                netGross: 'inc. VAT',
                monthCount: TimeMapEnum::from(($this->faker->randomElement(TimeMapEnum::values())))->months(),
                data: 'Data ' . $this->faker->sentence,
                discount: sprintf('Save %s%s on the monthly price', $currency, number_format($price / 12, 2, '.', ''))
            );
            $count--;
        }

        return $products;
    }
}
