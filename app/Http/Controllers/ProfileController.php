<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
   public function index(User $user){
       $series=$user->seriesBeingWatched();
       return view('profile')->withUser($user)->withSeries($series);

   }

   public function cardUpdate(){
       $user=auth()->user();
       $token=request('StripeToken');
       $user->updateCard($token);
       return response()->json(['status'=>'ok']);
   }
}
