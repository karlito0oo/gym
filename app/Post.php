<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
    public function posted_by()
    {
        return $this->hasOne('App\User', 'id', 'owner_id');
    }
    
    public function for_user()
    {
        return $this->hasOne('App\User', 'id', 'for_user_id');
    }
}
