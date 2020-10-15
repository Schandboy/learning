<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Series;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

//Route::get('/',function (){
////    Redis::set('friends','momo');
////    dd(Redis::get('friends'));
////    Redis::lpush('frameworks',['laravel','vuejs']);
////    dd(Redis::lrange('frameworks',0,-1));
//    Redis::sadd('frontend-framework',['angular','react','vue']);
//    dd(Redis::smembers('frontend-framework'));
//});
Route::get('/', 'FrontEndController@index');
//Route::get('/',function (){
//    $lesson=\App\Lesson::find(4);
//   auth()->user()->completeLesson($lesson);
//});
//Route::get('/', function () {
//    try {
//
//
//        $user = [['email' => 'susanchikanbanjar45@gmail.com',
//            'password' => 'Kris1607'],
//            [
//                'email' => 'kristsuwal2@gmail.com',
//                'password' => 'Kris1607'
//            ]];
//        foreach ($user as $u) {
//            $configuration = [
//                'smtp_host' => 'smtp.googlemail.com',
//                'smtp_port' => 465,
//                'smtp_username' => $u['email'],
//                'smtp_password' => $u['password'],
//                'smtp_encryption' => 'ssl',
//
//                'from_email' => $u['email'],
//                'from_name' => 'SCHANDBOY',
//            ];
//
//            $mailer = app()->makeWith('user.mailer', $configuration);
//            $mailer->send('message', [], function ($m) use ($u) {
//                $m->from($u['email'], 'Schandboy');
//
//                $m->to('schandboy@gmail.com')->subject("Paid Invoice Reminder");
//
//            });
//
//        }
//    }
//    catch (Exception $e){
//        dd($e);
//    }
//});
Route::get('/logout', function () {
    Auth::logout();
});


Route::get('/series/{series}', 'FrontEndController@series')->name('series');
//Route::get('{series_by_id}',function (Series $series){
//    dd($series);
//});

Route::get('profile/{user}', 'ProfileController@index')->name('user.profile');
Auth::routes();

Route::get('register/confirm', 'ConfirmEmailController@index')->name('confirm-email');
Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    Route::post('/card/update','ProfileController@cardUpdate')->name('card.update');
    Route::post('/series/complete-lesson/{lesson}', 'WatchSeriesController@completeLesson')->name('series.completeLesson');

    Route::get('series/{series}/lesson/{lesson}', 'WatchSeriesController@showLesson')->name('series.watch');
    Route::get('watch-series/{series}', 'WatchSeriesController@index')->name('series.learning');
    Route::get('subscribe', 'SubscriptionController@index');
    Route::post('subscriptions/change','SubscriptionController@change')->name('subscription.change');
    Route::post('subscribe', function (\Illuminate\Http\Request $request) {
        $stripe=$request->StripeToken;
        return auth()->user()->newSubscription(
            request('plan'), request('plan')
        )->create($stripe,[
            'email' => "schandboy@gmail.com"
        ]);
    });
});