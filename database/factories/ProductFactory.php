<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {
    return [

            'code'              => Str::random(5),
            'price'             => random_int(1,30),
            'image'             => Str::random(10),
            'name'              => $faker->name,
            'quantity'          => random_int(1,30),
            'manufacturing_date'=> now(),
            'shelflife_date'    => now(),
            'tenant_id'         => 1,
            'brand_id'          => 1,
            'model_id'          => 1,
            'model_id'          => 1,
            'category_id'       => 1,

    ];
});
