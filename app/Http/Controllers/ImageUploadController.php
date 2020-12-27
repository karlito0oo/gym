<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $uploadTo)
    {
        $exploded = explode(',', $request->profilePicture);

        $decoded = base64_decode($exploded[1]);

        if(str_contains($exploded[0], 'jpeg')){
            $extension = 'jpg';
        }
        else{
            $extension = 'png';
        }

        $fileName = rand() . '.' . $extension;

        $path = public_path() . '/images/' . $uploadTo . '/' . $fileName;

        file_put_contents($path, $decoded);

        if($uploadTo == 'StudentImage'){
            $user = User::find($request->id);
            $user->profilePicture = $fileName;
            $user->save();
        }

        return $fileName;
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
}
