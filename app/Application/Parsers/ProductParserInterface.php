<?php

declare(strict_types=1);

namespace WirelessLogic\Application\Parsers;

interface ProductParserInterface
{
    /**
     * @return array[][]
     */
    public function parse(string $content, ProductHttpSourceMapInterface $map): array;
}
