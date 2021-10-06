<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
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

        $user = User::find($id);
        $user->name = $request->name;
        $user->lname = $request->lname;
        $user->birthday = $request->birthday;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->contactno = $request->contactno;

        return $user->save();
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

    public function fetch(Request $request){
        return User::all()
        ->when($request->type == 'Instructor', function ($query) {
            return $query->where('role_id', '3');
        });
    }

    public function settings()
    {
        $user = Auth::user();

        return view('settings', [
            'user' => $user,
        ]);
    }

    public function updatePassword(Request $request)
    {   
        $data = (object)[];
        $data->result = false;
        $data->message = 'Something went wrong';

        $user = User::find($request->id);

        $hasher = app('hash');
        if (!$hasher->check($request->currentPassword, $user->password)) {
            $data->message = 'Current password doesn\'t match.';
            return response()->json($data);
        }

        if($request->newPassword != $request->confirmPassword){
            $data->message = 'New password and confirm password doesn\'t match.';
            return response()->json($data);
        }

        $user->password = Hash::make($request->newPassword);
        $user->save();

        $data->result = true;
        
        return response()->json($data);

    }
}
