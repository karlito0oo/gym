<?php

namespace App;

use App\ActivityUserAnswer;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question', 'answer_1', 'answer_2', 'answer_3', 'answer_4', 'correct_answer', 'owner_id',
    ];

    public function user_answer($activity_id, $user_id){
        $answer = ActivityUserAnswer::select('*')
            ->where('activity_id', $activity_id)
            ->where('user_id', $user_id)
            ->where('question_id', $this->id)
            ->first();
        
        return $answer->answer;
    }
}
