<?php

namespace Tests\Unit;

use App\Lesson;
use App\Series;
use App\User;
use Illuminate\Support\Collection;
use Redis;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
use RefreshDatabase;
    public function test_a_user_can_complete_a_lesson(){
        $this->flushRedis();
        $user=factory(User::class)->create();
        $lesson=factory(Lesson::class)->create();
        $lesson2=factory(Lesson::class)->create([
            'series_id'=>1
        ]);
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);
        $this->assertEquals(
            Redis::smembers('user:1:series:1'),
            [1,2]
        );
        $this->assertEquals(
           $user->getLessonsCompleted($lesson->series),2
        );



    }

    public function test_can_get_percentage_for_series_completed(){
        $this->flushRedis();
        $user=factory(User::class)->create();
        $lesson=factory(Lesson::class)->create();
        factory(Lesson::class)->create(['series_id'=>1]);
        factory(Lesson::class)->create(['series_id'=>1]);
        $lesson2=factory(Lesson::class)->create([
            'series_id'=>1
        ]);
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);

        $this->assertEquals(
            $user->percentageCompletedForSeries($lesson->series),50
        );
    }

    public function test_can_know_user_has_started_series(){
        $this->flushRedis();
        $user=factory(User::class)->create();
        $lesson=factory(Lesson::class)->create();
        $lesson2=factory(Lesson::class)->create(['series_id'=>1]);
        $lesson3=factory(Lesson::class)->create();
        $user->completeLesson($lesson2);
        $this->assertTrue($user->hasStartedSeries($lesson->series));
        $this->assertFalse($user->hasStartedSeries($lesson3->series));
    }

    public function test_can_get_completed_lessons(){
        $this->flushRedis();
        $user=factory(User::class)->create();

        $lesson=factory(Lesson::class)->create();
        $lesson2=factory(Lesson::class)->create(['series_id'=>1]);
        $lesson3=factory(Lesson::class)->create(['series_id'=>1]);
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);
        $completed=$user->getCompletedLesson($lesson->series);
        $completedLessonIds=$completed->pluck('id')->all();
        $this->assertInstanceOf(Collection::class,$completed);
        $this->assertInstanceOf(Lesson::class,$completed->random());
        $this->assertTrue(in_array($lesson->id,$completedLessonIds));
        $this->assertTrue(in_array($lesson2->id,$completedLessonIds));
        $this->assertFalse(in_array($lesson3->id,$completedLessonIds));
    }

    public function test_can_get_number_of_completed_lesson_for_user(){
        $this->flushRedis();
        $user=factory(User::class)->create();

        $lesson=factory(Lesson::class)->create();
        $lesson2=factory(Lesson::class)->create(['series_id'=>1]);
        $lesson3=factory(Lesson::class)->create();
        $lesson4=factory(Lesson::class)->create(['series_id'=>2]);
        $lesson5=factory(Lesson::class)->create(['series_id'=>2]);
        $user->completeLesson($lesson);
        $user->completeLesson($lesson3);
        $user->completeLesson($lesson5);

        $this->assertEquals(3,$user->getTotalNoOfCompletedLessons());
    }

    public function test_can_get_next_lesson_to_be_watched_by_user(){
        $this->flushRedis();
        $user=factory(User::class)->create();

        $lesson=factory(Lesson::class)->create(['episode_number'=>100]);
        $lesson2=factory(Lesson::class)->create(['series_id'=>1,'episode_number'=>200]);
        $lesson3=factory(Lesson::class)->create(['series_id'=>1,'episode_number'=>300]);
        $lesson4=factory(Lesson::class)->create(['series_id'=>1,'episode_number'=>400]);
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);
        $nextLesson=$user->getNextLessonToWatch($lesson->series);
        $this->assertEquals($lesson3->id,$nextLesson->id);
        $user->completeLesson($lesson3);
        $this->assertEquals($lesson4->id,$user->getNextLessonToWatch($lesson->series)->id);
    }
}
