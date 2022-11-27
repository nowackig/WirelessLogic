<?php

declare(strict_types=1);

namespace WirelessLogic\Interfaces\Cli\Commands;

use Illuminate\Console\Command;
use WirelessLogic\Application\Factories\ProductJsonResponseFactory;
use WirelessLogic\Application\Product\ProductHttpSourceMap;
use WirelessLogic\Application\Services\ProductSearchService;
use WirelessLogic\Application\Services\ProductSortService;

class WirelessLogic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wireless-logic:get-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Return product information by analyzing website content';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        private readonly ProductSearchService $productSearchService,
        private readonly ProductSortService $productSortService,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $products = $this->productSearchService->search(ProductHttpSourceMap::TEST_PAGE);

        echo ProductJsonResponseFactory::create(
            $this->productSortService->sort($products, ProductSortService::SORT_DESC)
        );
    }
}
