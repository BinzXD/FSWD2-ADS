<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = Product::create([
            'name' => 'Casing Hp lucu',
            'category_id' => 1,
            'slug' => Str::slug('Casing Hp lucu'),
            'price' => 78000 
        ]);

        DB::table('product_assets')->insert([
            ['product_id' => $product->id, 'image' => 'image/default.png'],
            ['product_id' => $product->id, 'image' => 'image/lucu.png'],
        ]);
    }
}
