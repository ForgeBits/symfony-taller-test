<?php

namespace App\Memory;

use App\Entities\Product;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ProductCollection
{
    private array $products;

    public function __construct()
    {
        $this->products = [];
    }

    public function addProduct(Product $product): void
    {
        $this->products[$product->getId()] = $product;
    }

    public function getProduct(int $id): Product
    {
        return $this->products[$id] ?? throw new ResourceNotFoundException(message:  "Product with id $id not found");
    }

    public function list(): array
    {
        return $this->products;
    }

    public function update(Product $product): void
    {
        $this->products[$product->getId()] = $product;
    }

    public function delete(string $id): void
    {
        unset($this->products[$id]);
    }
}