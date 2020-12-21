<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth' => 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        if(!$user){
            abort(404);
        }
        //get home page
        if($user->role->name == 'Student'){
            return view('student/home', [
                'user' => $user,
            ]);
        }
        elseif($user->role->name == 'Super Admin'){
            return view('admin/home', [
                'user' => $user,
            ]);
        }
        elseif($user->role->name == 'Instructor'){
            return view('instructor/home', [
                'user' => $user,
            ]);
        }
    }
}
