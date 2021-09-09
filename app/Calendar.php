<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use SoftDeletes;
    
    public function users(){
        return $this->belongsToMany('App\User')->withPivot('status');
    }
    
    public function approvedUsers(){
        return $this->belongsToMany('App\User')
            ->wherePivot('status', 'approved');
    }
    
    public function pendingUsers(){
        return $this->belongsToMany('App\User')
            ->wherePivot('status', 'pending');
    }
}
