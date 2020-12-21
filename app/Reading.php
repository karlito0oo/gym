<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    protected $fillable = [
        'title', 'description', 'data', 'genre_id', 'difficulty',
    ];

    public function genre()
    {
        return $this->hasOne('App\Genre', 'id', 'genre_id');
    }
}
