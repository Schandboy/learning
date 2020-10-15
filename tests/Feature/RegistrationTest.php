<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use WithoutMiddleware,RefreshDatabase;
  public function test_user_has_default_username(){
      $this->post('/register',[
          'name'=>'Admin Panel',
          'email'=>'admin@gmail.com',
          'password'=>'12345678'
      ])->assertRedirect();

      $this->assertDatabaseHas('users',[
          'username'=>str_slug('Admin Panel')
      ]);
  }

  public function test_an_email_sent_to_registered_users(){
      Mail::fake();
      $this->post('/register',[
          'name'=>'Admin Panel',
          'email'=>'admin@gmail.com',
          'password'=>'12345678'
      ])->assertRedirect();

      Mail::assertSent(ConfirmYourEmail::class);
  }

  public function test_confirm_token(){
      $this->withoutExceptionHandling();
      Mail::fake();
      $this->post('/register',[
          'name'=>'Admin Panel',
          'email'=>'admin@gmail.com',
          'password'=>'12345678'
      ])->assertRedirect();
      $user=User::first();
      $this->assertFalse($user->isConfirmed());
      $this->assertNotNull($user->confirm_token);
  }
}
