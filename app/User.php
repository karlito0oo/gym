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

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

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

    
    protected $appends = ['instructor', 'answeredActivityCount', 'studentSameSectionCount', 'postCount', 'upcomingActivityCount', 'section'];

    public function section(){
        return $this->hasOne('App\Section', 'id', 'section_id');
    }

    public function role(){
        return $this->hasOne('App\Role', 'id', 'role_id');
    }
    
    public function getInstructorAttribute(){
        return User::select('users.*')
            ->join('sections', 'sections.instructor_id', '=', 'users.id')
            ->where('sections.id', $this->section_id)
            ->first();
    }

    public function getansweredActivityCountAttribute(){
        $data = ActivityUserAnswer::select('activity_id', 'user_id')
            ->where('user_id', $this->id)
            ->distinct()
            ->get();
        return count($data);
    }

    public function getstudentSameSectionCountAttribute(){
        $data = User::
            where('section_id', $this->section_id)
            ->distinct()
            ->get();
        return count($data);
    }

    public function getpostCountAttribute(){
        $data = Post::
        where('owner_id', $this->id)
        ->distinct()
        ->get();

        return count($data);
    }

    public function getupcomingActivityCountAttribute(){
        $dateToday =  date("Y-m-d h:i:s");
        $data = Activity::
            where(DB::raw("CONCAT(dateStart, ' ', dateStartTime)"), '>', $dateToday)
            ->get();
        return count($data);
    }

    public function getSectionAttribute(){
        return Section::find($this->section_id);
    }
}
