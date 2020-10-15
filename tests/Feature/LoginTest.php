<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase,WithoutMiddleware;
/** @test */
    public function check_response_after_success_login(){
        $user = factory(User::class)->create();
        $this->postJson('/login', [
            'email' => $user->email,
            'password' => '12345678'
        ])->assertStatus(200)
            ->assertJson(['success'=>'ok'])
            ->assertSessionHas('success','Successfully Logged In.');

    }
///** @test */
    public function check_user_login_credentials()
    {
        $user = factory(User::class)->create();
        $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'wrong-password'
        ])->assertStatus(422)
            ->assertJson([
                'message' => 'These credentials do not match our records.'
            ]);
    }
}
