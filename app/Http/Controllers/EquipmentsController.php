<?php

namespace App\Http\Controllers;

use App\Equipment;
use Illuminate\Http\Request;
use Auth;

class EquipmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Equipment::all();
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
        $equipment = new Equipment();

        $equipment->name = $request->name;
        $equipment->description = $request->description;
        $equipment->subDescription = $request->subDescription;
        $equipment->embedLink = $request->embedLink;
        $equipment->save();

        return $equipment;
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
    public function edit($id, Request $request)
    {
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
        $equipment = Equipment::find($id);

        $equipment->name = $request->name;
        $equipment->description = $request->description;
        $equipment->subDescription = $request->subDescription;
        $equipment->embedLink = $request->embedLink;
        $equipment->save();

        return $equipment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Equipment::find($id)->delete();
    }

    public function pageHome()
    {
        $user = Auth::user();

        return view('equipments', [
            'user' => $user,
        ]);
    }
}
