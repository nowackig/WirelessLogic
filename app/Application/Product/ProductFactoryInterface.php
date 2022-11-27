<?php

namespace WirelessLogic\Application\Product;

interface ProductFactoryInterface
{
    public function create(array $data): Product;
}
