<?php

namespace App\Http\Controllers;

use App\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendancesController extends Controller
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

    public function userAttendanceToday(Request $request)
    {
        return Attendance::where('user_id', $request->id)
            ->whereDate('in', Carbon::today()->format('Y-m-d'))
            ->where('out', null)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function timeInOut(Request $request)
    {
        if($request->action == 'timeIn'){
            $attendance = new Attendance();
            $attendance->user_id = $request->user_id;
            $attendance->in = Carbon::now();
            $attendance->save();
        }
        else{
            $attendance = Attendance::find($request->attendance_id);
            $attendance->out = Carbon::now();
            $attendance->save();
        }

        return $attendance;
    }
}
