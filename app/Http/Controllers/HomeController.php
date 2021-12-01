<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Attendance;
use App\Calendar;
use App\User;
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
            $attendedToday = Attendance::select('user_id')
                ->whereDate('created_at', Carbon::today())
                ->distinct()
                ->get()
                ->count();
            
            $slots = Calendar::where('start', Carbon::today())->get();
            $reservedToday = 0;
            foreach($slots as $slot){
                $reservedToday = $slot->users->count();
            }
                
            return view('admin/home', [
                'user' => $user,
                'attendedToday' => $attendedToday,
                'reservedToday' => $reservedToday,
            ]);
        }
    }
}
