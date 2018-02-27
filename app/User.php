<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    		'name', 'email', 'password', 'privileges', 'promo_id', 'role', 'admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'privileges', 'password', 'remember_token', 'promo_id',
    ];
    
    public function promos()
    {
    	return $this->hasMany('App\Promo');
    }
    
    
}
