<?php

namespace App;

use App\Entities\Learning;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Redis;

class User extends Authenticatable
{
    use Notifiable,Learning,Billable;
protected $with=['subscriptions'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'confirm_token','stripe_id','card_brand','card_last_four'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isConfirmed()
    {
        return $this->confirm_token == null;
    }

    public function confirm()
    {
        $this->confirm_token = null;
        $this->save();
    }

    public function isAdmin()
    {
        return in_array($this->email, config('admin.administrators'));
    }

}
