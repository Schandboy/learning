<?php

namespace Tests\Feature;

use App\Series;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateSeriesTest extends TestCase
{

    public function test_a_user_can_update_series()
    {
        $this->withoutExceptionHandling();
        $this->loginAdmin();
        $this->withoutMiddleware();
        Storage::fake(config('filesystems.default'));
        $series = factory(Series::class)->create();

        $this->put(route('series.update', $series->slug), [

                'title' => 'Vue Description',
                'description' => 'Vue Dsescription',
                'image' => UploadedFile::fake()->image('image-series.png')

            ]
        )->assertRedirect(route('series.index'))
            ->assertSessionHas('success', 'Series Updated Successfully');

        Storage::disk(config('filesystems.default'))->assertExists(
            'public/series/' . str_slug('Vue Description') . '.png'
        );
        $this->assertDatabaseHas('series',[
            'slug'=>str_slug('Vue Description'),
            'image_url'=>'series/Vue-Description.png'
        ]);
    }

    public function test_image_is_not_required(){
        $this->withoutExceptionHandling();
        $this->loginAdmin();
        $this->withoutMiddleware();
        Storage::fake(config('filesystems.default'));
        $series = factory(Series::class)->create();

        $this->put(route('series.update', $series->slug), [

                'title' => 'Vue Description',
                'description' => 'Vue Dsescription',
//                'image' => UploadedFile::fake()->image('image-series.png')

            ]
        )->assertRedirect(route('series.index'))
            ->assertSessionHas('success', 'Series Updated Successfully');

        Storage::disk(config('filesystems.default'))->assertMissing(
            'series/' . str_slug('Vue Description') . '.png'
        );
        $this->assertDatabaseHas('series',[
            'slug'=>str_slug('Vue Description'),
            'image_url'=>$series->image_url
        ]);
    }
}
