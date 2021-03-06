<?php

namespace Tests\Unit;

use App\Lesson;
use App\Series;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeriesTest extends TestCase
{
    use RefreshDatabase;
    public function test_series_can_get_image_path()
    {
        $series = factory(Series::class)->create([
            'image_url' => 'series/test.jpg'
        ]);
        $image_path=$series->image_path;
        $this->assertEquals(asset('storage/series/test.jpg'),$image_path);

    }

    public function test_can_get_ordered_lesson_from_series(){
        $lesson=factory(Lesson::class)->create(['episode_number'=>200]);

        $lesson2=factory(Lesson::class)->create(['episode_number'=>100,'series_id'=>1]);
        $lesson3=factory(Lesson::class)->create(['episode_number'=>300,'series_id'=>1]);

        $lessons=$lesson->series->getOrderedLessonsfromSeries();

        $this->assertInstanceOf(Lesson::class,$lessons->random());
        $this->assertEquals($lessons->first()->id,$lesson2->id);
        $this->assertEquals($lessons->last()->id,$lesson3->id);
    }
}
