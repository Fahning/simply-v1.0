<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Product::class, 50)->create()->each(function ($product) {
            $product()->save(factory(App\Product::class)->make());
        });
    }
}
