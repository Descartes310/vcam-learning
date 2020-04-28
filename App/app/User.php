<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    
    protected $guarded = [];
    //protected $fillable = ['first_name', 'last_name', '...etc']

    
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

    
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
}
