<?php

use Faker\Generator as Faker;

$factory->define(App\Lesson::class, function (Faker $faker) {
    return [
        'title'=>$faker->sentence(5),
        'description'=>$faker->paragraph(1),
        'series_id'=>function(){
        return factory(\App\Series::class)->create()->id;
        },
        'episode_number'=>100,
        'video_id'=>'23232'
    ];
});
