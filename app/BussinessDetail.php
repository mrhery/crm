<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BussinessDetail extends Model
{
    protected $table = 'bussiness_event_details';

    protected $fillable = [
        'student_id', 'training_course_id', 'bussiness_type', 'monthly_income'
    ];
}
