<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'product_name' => 'abc',
            'product_price' => '150',
            'product_gst' => '12.5',
        ]);

        Product::create([
            'product_name' => 'bcd',
            'product_price' => '254',
            'product_gst' => '11.6',
        ]);

        Product::create([
            'product_name' => 'cde',
            'product_price' => '145',
            'product_gst' => '10.5',
        ]);

        Product::create([
            'product_name' => 'def',
            'product_price' => '120',
            'product_gst' => '6.5',
        ]);

         Product::create([
            'product_name' => 'efg',
            'product_price' => '110',
            'product_gst' => '5.5',
        ]);

          Product::create([
            'product_name' => 'fgh',
            'product_price' => '183',
            'product_gst' => '2.5',
        ]);

          Product::create([
            'product_name' => 'ghi',
            'product_price' => '124',
            'product_gst' => '2.6',
        ]);

          Product::create([
            'product_name' => 'hij',
            'product_price' => '163',
            'product_gst' => '1.5',
        ]);

          Product::create([
            'product_name' => 'ijk',
            'product_price' => '524',
            'product_gst' => '8.7',
        ]);

          Product::create([
            'product_name' => 'jkl',
            'product_price' => '416',
            'product_gst' => '4.5',
        ]);

          Product::create([
            'product_name' => 'klm',
            'product_price' => '156',
            'product_gst' => '7.8',
        ]);          
          
        
    }
}
