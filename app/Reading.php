<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    protected $fillable = [
        'name', 'description', 'data', 'genre_id',
    ];

    public function genre()
    {
        return $this->hasOne('App\Genre', 'id', 'genre_id');
    }
}
