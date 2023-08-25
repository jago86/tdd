<?php

namespace App\Business;

class TotalPriceCalculator
{
    public function __construct(protected array $products)
    {}

    public function total()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total = $total + ($product['price'] * $product['quantity']);
        }

        return $total;
    }

    public function details()
    {
        return $this->products;
    }

    public function add(array $product)
    {
        array_push($this->products, $product);
    }
}
