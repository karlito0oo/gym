<?php

namespace App\Http\Controllers;

use Auth;
use App\Section;
use Illuminate\Http\Request;

class SectionsController extends Controller
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
    public function index(Request $request)
    {
        $user = Auth::user();
        $columns = ['name', 'description', 'instructor_id'];

        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Section::select('*')->with('instructor')
        ->when($user->role_id == '3', function ($query) use ($user) {
            return $query->where('instructor_id', $user->id);
        })
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
        $user = Auth::user();
        $section = new Section();
        $section->name = $request->name;
        $section->description = $request->description;
        $section->owner_id = $user->id;
        $section->save();
        return $section;
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
        
        $this->validateData($request);

        $data = Section::find($id);

        $data->name = $request->name;
        $data->description = $request->description;

        return $data->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Section::find($id)->delete();
    }

    public function pageHome(){
        $user = Auth::user();
        return view('admin/sections', [
            'user' => $user,
        ]);
    }

    public function fetch($type = null, $id = null){
        return Section::all()
        ->when($type == 'Instructor', function ($query) use ($id) {
            return $query->where('owner_id', $id);
        });
    }
}
