<?php

use Faker\Generator as Faker;

$factory->define(App\Thread::class, function (Faker $faker) {
    return [
        $title = $faker->sentence;

    	'user_id' => function() {
    		return factory('App\User')->create()->id;
    	},
    	'channel_id' => function() {
    		return factory('App\Channel')->create()->id;
    	},
        'title' => $title,
        'body' => $faker->paragraph,
        'visits' => 0,
        'slug' => str_slug($title)
    ];
});