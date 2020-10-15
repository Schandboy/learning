<?php

namespace Tests\Feature;

use App\Series;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateLessionTest extends TestCase
{
    use RefreshDatabase;
    public function test_a_user_can_create_lesson()
    {
        $this->loginAdmin();
        $this->withoutMiddleware();
        $series = factory(Series::class)->create();
        $lessons = [
            'title' => 'Hello Lesson',
            'description' => 'Hello Lessdson',
            'episode_number' => 33,
            'video_id' => 3333,
        ];
        $this->postJson("admin/{$series->id}/lessons", $lessons)->assertStatus(200)
            ->assertJson($lessons);
        $this->assertDatabaseHas('lessons',[
            'title'=>$lessons['title']
        ]);
    }

    public function test_title_is_required(){
        $this->loginAdmin();
        $this->withoutMiddleware();
//        $this->withoutExceptionHandling();
        $series = factory(Series::class)->create();
        $lessons = [
//            'title' => 'Hello Lesson',
            'description' => 'Hello Lessdson',
            'episode_number' => 33,
            'video_id' => 3333,
        ];
        $this->post("admin/{$series->id}/lessons", $lessons)
            ->assertSessionHasErrors('title');
    }
    public function test_description_is_required(){
        $this->loginAdmin();
        $this->withoutMiddleware();
//        $this->withoutExceptionHandling();
        $series = factory(Series::class)->create();
        $lessons = [
            'title' => 'Hello Lesson',
//            'description' => 'Hello Lessdson',
            'episode_number' => 33,
            'video_id' => 3333,
        ];
        $this->post("admin/{$series->id}/lessons", $lessons)
            ->assertSessionHasErrors('description');
    }
    public function test_ep_no_is_required(){
        $this->loginAdmin();
        $this->withoutMiddleware();
//        $this->withoutExceptionHandling();
        $series = factory(Series::class)->create();
        $lessons = [
            'title' => 'Hello Lesson',
            'description' => 'Hello Lessdson',
//            'episode_number' => 33,
            'video_id' => 3333,
        ];
        $this->post("admin/{$series->id}/lessons", $lessons)
            ->assertSessionHasErrors('episode_number');
    }
    public function test_video_id_is_required(){
        $this->loginAdmin();
        $this->withoutMiddleware();
//        $this->withoutExceptionHandling();
        $series = factory(Series::class)->create();
        $lessons = [
            'title' => 'Hello Lesson',
            'description' => 'Hello Lessdson',
            'episode_number' => 33,
//            'video_id' => 3333,
        ];
        $this->post("admin/{$series->id}/lessons", $lessons)
            ->assertSessionHasErrors('video_id');
    }
}
