<?php

namespace App\Http\Controllers;

use Auth;
use App\Calendar;
use App\User;
use App\Http\Resources\CalendarResource;
use Illuminate\Http\Request;

class CalendarsController extends Controller
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

    public function validateData(Request $request){
        $temp = request()->validate(
            [
                'name' => 'required',
                'description' => 'required',
                'instructor_id' => 'required',
            ]
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $events = Calendar::all();

        return CalendarResource::collection($events);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $calendar = new Calendar();
        $calendar->title = date('h:i a', strtotime($request->timeStart)) . ' - ' . date('h:i a', strtotime($request->timeEnd));
        $calendar->start = $request->start;
        $calendar->end = $request->end;
        $calendar->timeStart = $request->timeStart;
        $calendar->timeEnd = $request->timeEnd;
        $calendar->owner_id = $user->id;
        $calendar->capacity = $request->capacity;
        $calendar->save();
        return $calendar;
    }

    public function reserve(Request $request)
    {
        $user = Auth::user();
        
        $user->calendars()->attach($request->id, ['status' => 'pending']);

        return $user;
    }

    public function cancel($id)
    {
        $user = Auth::user();
        
        $user->calendars()->detach($id);

        return $user;
    }

    public function approve(Request $request)
    {
        $calendar = Calendar::find($request->id);

        $user = User::find($request->user_id);

        $calendar->users()->updateExistingPivot($user, array('status' => 'approved'), 'pending');

        return $calendar;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CalendarResource(Calendar::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $calendar = Calendar::find($id);

        $calendar->title = date('h:i a', strtotime($request->timeStart)) . ' - ' . date('h:i a', strtotime($request->timeEnd));
        $calendar->start = $request->start;
        $calendar->end = $request->end;
        $calendar->timeStart = $request->timeStart;
        $calendar->timeEnd = $request->timeEnd;
        $calendar->capacity = $request->capacity;
        $calendar->save();

        return $calendar->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Calendar::find($id)->delete();
    }

}
