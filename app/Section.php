<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'name', 'description', 'owner_id',
    ];

    public function instructor()
    {
        return $this->hasOne('App\User', 'id', 'instructor_id');
    }

    public function students(){
        return $this->hasMany('App\User', 'section_id', 'id');
    }
}
