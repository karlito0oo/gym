<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function validateData(Request $request){
        $validator = [
            'name' => 'required',
            'lname' => 'required',
            'email' => 'required',
        ];
        $temp = request()->validate($validator);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $columns = ['name', 'lname', 'email', 'gender'];

        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = User::select('users.*')
        ->with('role')
        ->orderBy($columns[$column], $dir);



        if ($searchValue) {
            $query->where(function($query) use ($searchValue, $columns) {
                foreach(array_keys($columns) as $key){
                    $query->orWhere($columns[$key], 'like', '%' . $searchValue . '%');
                }
            });
        }

        $projects = $query->paginate($length);
        return ['data' => $projects, 'draw' => $request->input('draw')];
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
        $viewer = Auth::user();
        $user = User::where('id', $id)->with('section')->first();
        return view('student/profile', [
            'user' => $user,
            'viewer' => $viewer,
        ]);
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
        $this->validateData($request);

        $student = User::find($id);
        $student->name = $request->name;
        $student->lname = $request->lname;
        $student->birthday = $request->birthday;
        $student->gender = $request->gender;
        $student->email = $request->email;
        $student->contactno = $request->contactno;

        return $student->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return User::find($id)->delete();
    }

    public function pageHome(){
        $user = Auth::user();
        return view('admin/members', [
            'user' => $user,
        ]);
    }

    public function updateSection(Request $request, $id){
        $temp = request()->validate(
            [
                'section_id' => 'required',
            ],
            [
                'section_id.required' => 'The section field is required.',
            ]
        );
        $student = User::find($id);
        $student->section_id = $request->section_id;
        $student->save();
        return $student;
    }

    public function updateUserType(Request $request, $id){
        $user = User::find($id);
        $user->role_id = $request->user_type;
        $user->save();
        return $user;
    }
}
