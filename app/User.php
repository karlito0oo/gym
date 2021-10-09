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
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'lname', 'gender', 'role_id', 'user_name',
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

    
    protected $appends = ['userRole', 'memberSince', 'firstAttend', 'lastAttend', 'totalAttend'];

    public function calendars(){
        return $this->belongsToMany('App\Calendar');
    }

    public function role(){
        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    public function attendances(){
        return $this->hasMany('App\Attendance', 'user_id', 'id')->orderBy('id', 'desc');
    }

    public function getUserRoleAttribute(){
        return $this->role->name;
    }

    public function getMemberSinceAttribute(){
        return Carbon::parse($this->created_at)->format('M d, Y');
    }

    public function getFirstAttendAttribute(){
        $date = $this->attendances->last();

        return ($date ? Carbon::parse($date->in)->format('M d, Y g:i A') : '-');
    }

    public function getLastAttendAttribute(){
        $date = $this->attendances->first();

        return ($date ? Carbon::parse($date->out)->format('M d, Y g:i A') : '-');
    }

    public function getTotalAttendAttribute(){

        return $this->attendances->count();
    }
    
}
