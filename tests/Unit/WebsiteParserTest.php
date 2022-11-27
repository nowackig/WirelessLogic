<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\Generators\FakerGenerator;
use Tests\Generators\ResponseGenerator;
use Tests\TestCase;
use WirelessLogic\Application\Factories\ProductJsonResponseFactory;
use WirelessLogic\Application\Parsers\ProductParserInterface;
use WirelessLogic\Application\Product\Product;
use WirelessLogic\Application\Product\ProductCollection;
use WirelessLogic\Application\Product\ProductHttpSourceMap;
use WirelessLogic\Application\Product\ProductMapperInterface;

class WebsiteParserTest extends TestCase
{
    private FakerGenerator $fakerGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fakerGenerator = new FakerGenerator();
    }

    public function test_should_return_parsed_web_content(): array
    {
        // arrange
        $products = $this->fakerGenerator->products(2);
        $response = ResponseGenerator::websiteResponse($products);
        $expectedParserResponse = ResponseGenerator::parsedProductsResponse($products);
        $parser = $this->app->get(ProductParserInterface::class);

        //act
        $parsedProducts = $parser->parse($response, ProductHttpSourceMap::TEST_PAGE);

        //assert
        $this->assertEquals($expectedParserResponse, $parsedProducts);

        return ['parsedData' => $parsedProducts, 'products' => $products];
    }

    /**
     * @depends test_should_return_parsed_web_content
     */
    public function test_should_map_parsed_web_content(array $data): ProductCollection
    {
        // arrange
        /** @var ProductMapperInterface $mapper */
        $mapper = $this->app->get(ProductMapperInterface::class);

        // act
        $mappedData = $mapper->map($data['parsedData']);

        // assert
        $this->assertContainsOnlyInstancesOf(Product::class, $mappedData);
        foreach ($mappedData as $index => $product) {
            $this->assertEquals($data['products'][$index], $product);
        }

        return  $mappedData;
    }

    /**
     * @depends test_should_map_parsed_web_content
     */
    public function test_should_prepare_json_response(ProductCollection $products): void
    {
        // arrange
        $expectedJsonResponse = ResponseGenerator::jsonResponse($products);

        // act
        $jsonResponse = ProductJsonResponseFactory::create($products);

        // assert
        $this->assertSame($expectedJsonResponse, $jsonResponse);
    }
}
