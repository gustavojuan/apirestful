<?php

use App\User;
use App\Seller;
use App\Buyer;
use App\Product;
use App\Category;
use App\Transaction;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'verified'=>$faker->randomElement([User::USUARIO_VERIFICADO, User::USUARIO_NO_VERIFICADO]),
	    'verification_token'=> $verificado  == User::USUARIO_VERIFICADO ? null :User::generarVerificationToken(),
        'admin'=>$faker->randomElement([User::USUARIO_ADMINISTRADOR, User::USUARIO_REGULAR]),

    ];
});

$factory->define(Category::class, function (Faker\Generator $faker) {

	return [
		'name' => $faker->word,
		'description'=> $faker->paragraph(1),

	];
});


$factory->define(Product::class, function (Faker\Generator $faker) {

	return [
		'name' => $faker->word,
		'description'=> $faker->paragraph(1),
		'quantity'=> $faker->numberBetween(1,10),
		'status'=> $faker->randomElement([Product::PRODUCTO_NO_DISPONIBLE,Product::PRODUCTO_DISPONIBLE]),
		'imagen'=> $faker->randomElement(['1.jpg','2.jpg','3.jpg']),
		/*'seller_id'=> User::inRandomOrder()->first()->id,*/
		'seller_id'=>User::all()->random()->id()

	];
});

$factory->define(Transaction::class, function (Faker\Generator $faker) {

	$seller = Seller::has('products')->get()->random(1);
	$buyer = User::all()->except($seller->id)->random(1);

	return [
		'description'=> $faker->paragraph(1),
		'buyer_id'=> $buyer->id,
		'product_id'=> $seller->products->random()->id
	];
});

