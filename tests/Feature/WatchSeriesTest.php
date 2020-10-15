<?php

namespace Tests\Feature;

use App\Lesson;
use App\Series;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WatchSeriesTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function test_a_user_can_complete_lesson()
    {
        $this->flushRedis();
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create(['series_id' => 1]);
        $response = $this->post("/series/complete-lesson/{$lesson->id}", []);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'ok'
        ]);
        $this->assertTrue($user->hasCompletedLesson($lesson));
        $this->assertFalse($user->hasCompletedLesson($lesson2));
    }

    public function test_if_user_has_completed_lesson(){
       $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create(['series_id' => 1]);
        $user->completeLesson($lesson);
        $this->assertTrue($user->hasCompletedLesson($lesson));
        $this->assertFalse($user->hasCompletedLesson($lesson2));
    }

    public function test_can_get_all_series_watched(){
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create(['series_id' => 1]);
        $lesson3 = factory(Lesson::class)->create();
        $lesson4 = factory(Lesson::class)->create(['series_id' => 2]);
        $lesson5 = factory(Lesson::class)->create();
        $lesson6 = factory(Lesson::class)->create(['series_id' => 3]);
        $user->completeLesson($lesson);
        $user->completeLesson($lesson3);
        $started_series=$user->seriesBeingWatched();

        $this->assertInstanceOf(Collection::class,$started_series);
        $this->assertInstanceOf(Series::class,$started_series->random());
        $ids_of_started_series=$started_series->pluck('id')->all();
        $this->assertTrue(in_array($lesson->series->id,$ids_of_started_series));
        $this->assertTrue(in_array($lesson3->series->id,$ids_of_started_series));
        $this->assertFalse(in_array($lesson5->series->id,$ids_of_started_series));
    }
}
