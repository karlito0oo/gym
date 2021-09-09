<?php

namespace App;

use App\User;
use App\Role;
use App\Section;
use App\Activity;
use App\ActivityUserAnswer;
use App\Post;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'lname', 'gender', 'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    protected $appends = ['userRole'];

    public function calendars(){
        return $this->belongsToMany('App\Calendar');
    }

    public function role(){
        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    public function getUserRoleAttribute(){
        return $this->role->name;
    }
    
}
