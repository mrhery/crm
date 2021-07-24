<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    protected $guard = 'student';

    protected $fillable = [
        'stud_id', 'first_name', 'last_name', 'ic', 'email', 'phoneno', 'membership_id', 'level_id', 'status'
    ];

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }
}
