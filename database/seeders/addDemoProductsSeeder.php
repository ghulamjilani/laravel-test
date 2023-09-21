<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Model
use App\Models\Product;


class addDemoProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'title'         => "Demo Product for B2B",
            'description'   => "demo product with category B2B",
            'price'         => "100.00",
            'category_id'   => 1,
            'quantity'      => "10",
            'sold_quantity' => "0",
        ]);
        Product::create([
            'title'         => "Demo Product for B2C",
            'description'   => "demo product with category B2C",
            'price'         => "150.00",
            'category_id'   => 2,
            'quantity'      => "12",
            'sold_quantity' => "0",
        ]);
    }
}
