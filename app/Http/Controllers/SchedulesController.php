<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
Use Carbon\Carbon;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function pageHome(){
        $user = Auth::user();
        return view('admin/schedules', [
            'user' => $user,
        ]);
    }

    public function reservationsDT(Request $request){
        $columns = ['name', 'start', 'status'];

        $length = $request->input('length');

        $query = User::select('calendars.start', 'calendars.end', 'calendars.timeStart', 'calendars.timeEnd', 'users.name', 'users.lname', 'calendar_user.status', 'calendars.id as calendarID', 'users.id as userID')
            ->join('calendar_user', 'users.id', 'calendar_user.user_id')
            ->join('calendars', 'calendars.id', 'calendar_user.calendar_id')
            ->where('calendars.start', '>=', Carbon::today())
            ->where('calendar_user.status', 'pending')
            ->orderBy('calendars.start');


        $projects = $query->paginate($length);
        return ['data' => $projects, 'draw' => $request->input('draw')];
    }
}
