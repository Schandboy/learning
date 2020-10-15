<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateSeriesTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function test_a_user_can_create_a_series()
    {
        $this->withoutExceptionHandling();
        $this->loginAdmin();
        Storage::fake(config('filesystems.default'));
        $this->post('admin/series', [
            'title' => 'Vue JS',
            'description' => 'Vue Description',
            'image' => UploadedFile::fake()->image('image-series.png')
        ])->assertRedirect()
            ->assertSessionHas('success', 'Series Created Successfully.');

        Storage::disk(config('filesystems.default'))->assertExists(
            'public/series/' . str_slug('Vue Js') . '.png'
        );
        $this->assertDatabaseHas('series', [
            'slug' => str_slug('Vue JS')
        ]);


    }

    public function test_a_series_have_a_title()
    {
        $this->loginAdmin();
        $this->post('admin/series', [
            'description' => 'Vue Description',
            'image' => UploadedFile::fake()->image('image-series.png')
        ])
            ->assertSessionHasErrors('title');

    }

    public function test_a_series_have_a_description()
    {
        $this->loginAdmin();
        $this->post('admin/series', [
            'title' => 'Vue Description',
            'image' => UploadedFile::fake()->image('image-series.png')
        ])
            ->assertSessionHasErrors('description');

    }

    public function test_a_series_have_a_image()
    {
        $this->loginAdmin();
        $this->post('admin/series', [
            'title' => 'Vue Description',
            'description' => 'Vue Dsescription',
//            'image' => UploadedFile::fake()->image('image-series.png')
        ])
            ->assertSessionHasErrors('image');

    }

    public function test_a_series_have_a_image_which()
    {
        $this->loginAdmin();
        $this->post('admin/series', [
            'title' => 'Vue Description',
            'description' => 'Vue Dsescription',
            'image' => 'lskdfkldsf.png'
        ])
            ->assertSessionHasErrors('image');

    }

    public function test_only_admin_can_create_series()
    {
        //user
        $this->actingAs(factory(User::class)->create());
        //visit endpoint
        $this->post('admin/series')
            ->assertSessionHas('error', 'You are not authorized');
        //assert we are redirected
    }
}
