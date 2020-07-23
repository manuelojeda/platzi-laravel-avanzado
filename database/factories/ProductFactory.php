<?php
// phpcs:disable
/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\{ Category, Product };
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price' => $faker->numberBetween(10000, 60000),
        'category_id' => function () {
            return Category::query()->inRandomOrder()->first()->id;
        }
    ];
});
