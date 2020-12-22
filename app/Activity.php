<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

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
}
