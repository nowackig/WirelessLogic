<?php

declare(strict_types=1);

namespace WirelessLogic\Application\Services;

use WirelessLogic\Application\Product\Product;
use WirelessLogic\Application\Product\ProductCollection;

class ProductSortService
{
    public const SORT_ASC = 0;
    public const SORT_DESC = 1;
    public const ONE_YEAR = 12;
    public const MULITPLE_ONCE = 1;
    public const MULITPLE_BY_TWELVE = 12;

    public function sort(ProductCollection $products, int $direction = self::SORT_ASC): ProductCollection
    {
        $products->sort([self::class, 'comparePerAnnualFee']);

        return $direction ? $products : array_reverse($products);
    }

    public static function comparePerAnnualFee(Product $a, Product $b): int
    {
        $aMultiplier = $a->monthCount == self::ONE_YEAR ? self::MULITPLE_ONCE : self::MULITPLE_BY_TWELVE;
        $bMultiplier = $b->monthCount == self::ONE_YEAR ? self::MULITPLE_ONCE : self::MULITPLE_BY_TWELVE;

        $aAnnualFee = $a->price * $aMultiplier;
        $bAnnualFee = $b->price * $bMultiplier;

        return $bAnnualFee <=> $aAnnualFee;
    }
}
