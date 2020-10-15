<?php

use App\Lesson;
use App\Series;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => Hash::make('12345678')
        ]);

        $series = Series::create([
            'title' => 'VUE JS',
            'slug' => 'vue-js',
            'image_url' => 'series/hosting.gif',
            'description' => 'ok'
        ]);

        $lesson = Lesson::create([
            'series_id' => $series->id,
            'title' => 'Part 1',
            'description' => 'ok',
            'episode_number' => '100',
            'video_id' => 166903742,
            'premium' => 0

        ]);
        $lesson2 = Lesson::create([
            'series_id' => $series->id,
            'title' => 'Part 2',
            'description' => 'ok',
            'episode_number' => '200',
            'video_id' => 203810360,
            'premium' => 1

        ]);
        $lesson3 = Lesson::create([
            'series_id' => $series->id,
            'title' => 'Part 3',
            'description' => 'ok',
            'episode_number' => '300',
            'video_id' => 204201898,
            'premium' => 0

        ]);
        // $this->call(UsersTableSeeder::class);
    }
}
