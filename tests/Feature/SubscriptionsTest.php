<?php

namespace Tests\Feature;

use App\Lesson;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionsTest extends TestCase
{
    use RefreshDatabase;


    public function test_a_user_without_plan_can_watch_free_lessons()
    {
        $user = factory(User::class)->create();
        $this->fakeSubscribe($user);
        dd($user->subscribed('monthly'));
    }

    public function test_a_user_without_plan_cannot_watch_premium_lessons()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $lesson = factory(Lesson::class)->create(['premium' => 1]);
        $lesson2 = factory(Lesson::class)->create(['premium' => 0]);
        $this->get("/series/{$lesson->series->slug}/lesson/{$lesson->id}")
            ->assertRedirect('/subscribe');
        $this->get("/series/{$lesson2->series->slug}/lesson/{$lesson2->id}")
            ->assertViewIs('/watch');


    }

    public function test_a_user_on_any_plan_can_watch_all_lessons()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->fakeSubscribe($user);
        $lesson = factory(Lesson::class)->create(['premium' => 1]);
        $lesson2 = factory(Lesson::class)->create(['premium' => 0]);
        $this->get("/series/{$lesson2->series->slug}/lesson/{$lesson2->id}")
            ->assertViewIs('watch');
        $this->get("/series/{$lesson->series->slug}/lesson/{$lesson->id}")
            ->assertViewIs('watch');
    }

    public function fakeSubscribe($user)
    {
        $user->subscriptions()->create([
            'name' => 'yearly',
            'stripe_id' => 'FAKE_STRIPE_ID',
            'stripe_plan' => 'yearly',
            'quantity' => 1
        ]);
    }
}
