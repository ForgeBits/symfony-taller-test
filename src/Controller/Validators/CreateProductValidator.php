<?php

namespace App\Controller\Validators;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CreateProductValidator
{
    public function validated()
    {

    }
    
    public function name(string $name): self
    {
        if (empty($name)) {
            throw new BadRequestException('Product name cannot be empty', 400);
        }

        return $this;
    }

    public function description(string $description): self
    {
        if (empty($description)) {
            throw new BadRequestException('Product description cannot be empty', 400);
        }

        return $this;
    }

    public function price(float $price): self
    {
        if ($price <= 0) {
            throw new BadRequestException('Price must be greater than 0', 400);
        }

        return $this;
    }
}