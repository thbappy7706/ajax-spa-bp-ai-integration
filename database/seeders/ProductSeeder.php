<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $total = 100000;
        $chunkSize = 5000;
        $now = now();

        for ($i = 0; $i < $total; $i += $chunkSize) {
            $products = [];
            for ($j = 0; $j < $chunkSize; $j++) {
                $products[] = [
                    'name' => 'Product ' . Str::random(8),
                    'slug' => Str::slug('Product ' . Str::random(8) . '-' . uniqid()),
                    'sku'  => 'SKU-' . strtoupper(Str::random(6)),
                    'category' => ['Electronics', 'Hardware', 'Software', 'Clothing', 'Books'][rand(0, 4)],
                    'description' => 'Description for product',
                    'price' => rand(10, 1000) + (rand(0, 99) / 100),
                    'stock' => rand(0, 500),
                    'status' => ['Active', 'Draft', 'Archived'][rand(0, 2)],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('products')->insert($products);
        }
    }
}
