<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Business\TotalPriceCalculator;

class TotalPriceCalculatorTest extends TestCase
{
    /** @test */
    public function can_calculate_the_total_price()
    {
        $products = [
            [
                'name' => 'Apples',
                'price' => 1,
                'quantity' => 6,
            ],
            [
                'name' => 'Oranges',
                'price' => 2,
                'quantity' => 4,
            ],
        ];

        $calculator = new TotalPriceCalculator($products);
        $total = $calculator->total();

        $this->assertEquals(14, $total);
    }

    /** @test */
    public function can_get_product_list()
    {
        $products = [
            [
                'name' => 'Apples',
                'price' => 1,
                'quantity' => 6,
            ],
            [
                'name' => 'Oranges',
                'price' => 2,
                'quantity' => 4,
            ],
        ];

        $calculator = new TotalPriceCalculator($products);

        $this->assertEquals($products, $calculator->details());
    }

    /** @test */
    public function can_add_new_products()
    {
        $products = [
            [
                'name' => 'Apples',
                'price' => 1,
                'quantity' => 6,
            ],
            [
                'name' => 'Oranges',
                'price' => 2,
                'quantity' => 4,
            ],
        ];

        $calculator = new TotalPriceCalculator($products);
        $calculator->add([
            'name' => 'Bananas',
            'price' => 1.5,
            'quantity' => 2,
        ]);
        $total = $calculator->total();
        $expectedArray = [
            [
                'name' => 'Apples',
                'price' => 1,
                'quantity' => 6,
            ],
            [
                'name' => 'Oranges',
                'price' => 2,
                'quantity' => 4,
            ],
            [
                'name' => 'Bananas',
                'price' => 1.5,
                'quantity' => 2,
            ]
        ];
        $this->assertEquals($expectedArray, $calculator->details());
        $this->assertEquals(17, $total);
    }
}
