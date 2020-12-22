<?php

namespace App;

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
}
