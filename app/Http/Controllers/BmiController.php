<?php

namespace App\Http\Controllers;

use Auth;
use App\Bmi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BmiController extends Controller
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
        $user = Auth::user();

        $bmi = new Bmi();
        $bmi->user_id = $user->id;
        $bmi->bmi = $request->bmi;
        $bmi->save();

        return $bmi;

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

    public function chart()
    {
        $user = Auth::user();

        $monthsName = [];
        $bmiRecord = [];
        for ($i=12; $i >= 0; $i--) { 
            array_push($monthsName, Carbon::now()->subMonth($i)->format('F Y'));

            //get BMI
            $avg = Bmi::where('user_id', $user->id)
                ->whereMonth('created_at', Carbon::now()->subMonth($i)->format('m'))
                ->whereYear('created_at', Carbon::now()->subMonth($i)->format('yy'))
                ->avg('bmi');

            $avg = Bmi::select(\DB::raw('IFNULL(AVG(bmi), 0) as bmi'))
                ->where('user_id', $user->id)
                ->whereMonth('created_at', Carbon::now()->subMonth($i)->format('m'))
                ->whereYear('created_at', Carbon::now()->subMonth($i)->format('Y'))
                ->first();
            array_push($bmiRecord, $avg->bmi);

        }

        return [
            'months' => $monthsName,
            'bmis' => $bmiRecord,
        ];
    }
}
