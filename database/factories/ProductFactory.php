<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->randomElement([
            'موبایل سامسونگ',
            'لپ تاپ سونی',
            'لپ تاپ فوجیتسو',
            'مچبند شیاومی',
            'اسپیکر هارمن کاردن',
            'مودم ADSL',
            'پاور بانک',
            'دوربین',
            'کابل صدا',
            'باتری موبایل',
            'کتابخوان',
            'مانیتور ال جی',
            'تبلت سامسونگ',
        ]),
        'description' => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است',
        'image' => 'https://via.placeholder.com/286*180?text=image',
        'price' => $faker->randomElement([
            150000, 450000, 250000, 2521000, 150000
        ]),
        'stock' => $faker->randomDigitNotNull
    ];
});
