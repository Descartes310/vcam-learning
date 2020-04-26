<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table = 'role';
    protected $guarded = ['updated_at'];
    //protected $fillable = ['name'];
}
