<?php

namespace App;

use Auth;
use App\ActivitySection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Activity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'type', 'dateStart', 'dateEnd', 'owner_id',
    ];
    
    public function sections(){
        return $this->belongsToMany('App\Section');
    }
    
    public function questions(){
        return $this->belongsToMany('App\Question');
    }
    
    public function readings(){
        return $this->belongsToMany('App\Reading');
    }
    
    public function readers(){
        $user = Auth::user();
        if($user->role_id == 1){
            return  $this->belongsToMany('App\User', 'activity_reader', 'activity_id', 'user_id')
            ->withTimestamps()
            ->wherePivot('user_id', $user->id);
        }
        else{
            return  $this->belongsToMany('App\User', 'activity_reader', 'activity_id', 'user_id')
            ->withTimestamps();
        }
        
    }
    
    public function answered(){
        $user = Auth::user();
        if($user->role_id == 1){
            return  $this->belongsToMany('App\User', 'activity_user_answers', 'activity_id', 'user_id')
            ->withTimestamps()
            ->wherePivot('user_id', $user->id);
        }
        else{
            return  $this->belongsToMany('App\User', 'activity_user_answers', 'activity_id', 'user_id')
            ->withTimestamps()
            ->distinct();
        }
    }

    public function takers(){
        return DB::table('activity_section')
            ->select('users.*')
            ->where('activity_section.activity_id', $this->id)
            ->join('users', 'users.section_id', 'activity_section.section_id')
            ->get();
    }
}
