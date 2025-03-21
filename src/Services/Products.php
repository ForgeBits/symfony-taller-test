<?php

namespace App\Services;

use App\Entities\Product;

class Products
{
    public function create(array $data): Product
    {
        $product = new Product();
        $product
            ->setId($data['id'])
            ->setName($data['name'])
            ->setDescription($data['description'])
            ->setPrice($data['price']);

        return $product;
    }

    public function update(Product $product, array $data): Product
    {
        $product
            ->setId($data['id'])
            ->setName($data['name'])
            ->setDescription($data['description'])
            ->setPrice($data['price']);

        return $product;
    }
}