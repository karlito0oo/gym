<?php

namespace App\Http\Controllers;

use Auth;
use App\Calendar;
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

        $events = Calendar::
        when($user->role_id == '3', function ($query) use ($user) {
            return $query->where('owner_id', $user->id);
        })
        ->get();

        return $events;
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
        $calendar->title = $request->title;
        $calendar->start = $request->start;
        $calendar->end = $request->end;
        $calendar->owner_id = $user->id;
        $calendar->save();
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
        //
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

        $calendar->name = $request->title;
        $calendar->start = $request->start;
        $calendar->end = $request->end;
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
