<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfirmEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_confirm_email()
    {
        $this->withoutExceptionHandling();
        //create user
        //make a get request to the confirm endpoint
        //assert that the user is confirmed
        $user = factory(User::class)->create();
        $this->get("/register/confirm/?token={$user->confirm_token}")
            ->assertRedirect('/')
            ->assertSessionHas('success','Your email has been confirmed.');
        $this->assertTrue($user->fresh()->isConfirmed());
    }

    public function test_a_user_is_redirected_if_token_is_wrong(){
        $user = factory(User::class)->create();
        $this->get("/register/confirm/?token=WrongToken")
            ->assertRedirect('/')
            ->assertSessionHas('error','Email Not Confirmed');

    }
}
