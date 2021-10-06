<?php

namespace App\Http\Controllers;

use Auth;
use App\Activity;
use App\User;
use App\Section;
use App\Question;
use App\Reading;
use Illuminate\Support\Facades\DB;
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
        if($user->role->name == 'member'){
            return view('home', [
                'user' => $user,
            ]);
        }
        elseif($user->role->name == 'admin'){
            return view('admin/home', [
                'user' => $user,
            ]);
        }
    }
}
