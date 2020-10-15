<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(){
        return view('subscribe');
    }

    public function change(){
        $this->validate(\request(),[
            'plan'=>'required'
        ]);
        $user=auth()->user();
        $userPlan=$user->subscriptions->first()->stripe_plan;
        if ($userPlan===request('plan')){
            return redirect()->back();
        }
        $user->subscription($userPlan)->swap(request('plan'));
        return  redirect()->back();
    }
}
