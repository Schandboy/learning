<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
   protected $table=['subscriptions'];
   protected $fillable=['user_id','name','quantity','stripe_id','stripe_plan','trial_ends_at','ends_at'];
}
