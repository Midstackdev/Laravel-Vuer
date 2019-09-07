<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->text(50),
        'description' => $faker->text(200),
        'price' => '500',
        'amount' => '50'
    ];
});
