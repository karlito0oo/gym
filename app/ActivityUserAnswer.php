<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityUserAnswer extends Model
{
    protected $fillable = [
        'activity_id', 'question_id', 'user_id', 'answer',
    ];
}
