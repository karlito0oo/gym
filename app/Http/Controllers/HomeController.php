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
        if($user->role->name == 'Student'){
            return redirect()->away(url('/api/students/' . $user->id));
        }
        elseif($user->role->name == 'Super Admin'){
            return view('admin/home', [
                'user' => $user,
            ]);
        }
        elseif($user->role->name == 'Instructor'){

            $data['activities'] = Activity::where('owner_id', $user->id)->get();

            $data['students'] = Section::select('users.*')
            ->where('instructor_id', $user->id)
            ->join('users', 'users.section_id', '=', 'sections.id')
            ->get();

            $data['questions'] = Question::where('owner_id', $user->id)->get();

            $data['readingComprehensions'] = Reading::where('owner_id', $user->id)->get();

            $dateToday =  date("Y-m-d h:i:s");
            $data['ongoingActivities'] = Activity::
                where(DB::raw("CONCAT(dateStart, ' ', dateStartTime)"), '<=', $dateToday)
                ->where(DB::raw("CONCAT(dateEnd, ' ', dateEndTime)"), '>=', $dateToday)
                ->with('sections')
                ->with('answered')
                ->get();
            

            return view('instructor/home', [
                'user' => $user,
                'data' => $data,
            ]);
        }
    }
}
