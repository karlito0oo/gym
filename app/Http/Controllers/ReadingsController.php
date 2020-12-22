<?php

namespace App\Http\Controllers;

use Auth;
use App\Reading;
use Illuminate\Http\Request;

class ReadingsController extends Controller
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
                'title' => 'required',
                'description' => 'required',
                'data' => 'required',
                'genre_id' => 'required',
                'difficulty' => 'required',
            ],
            [
                'genre_id.required' => 'The genre field is required.',
                'data.required' => 'The story field is required.',
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
        $columns = ['title', 'description', 'difficulty', 'genre_id', 'data'];

        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Reading::select('*')->with('genre')
        ->when($user->role_id == '3', function ($query) use ($user) {
            return $query->where('owner_id', $user->id);
        })
        ->when($user->role_id == '1', function ($query) use ($user) {
            return $query->where('owner_id', $user->id);
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
        $this->validateData($request);

        $data = new Reading();

        $data->title = $request->title;
        $data->description = $request->description;
        $data->data = $request->data;
        $data->genre_id = $request->genre_id;
        $data->difficulty = $request->difficulty;
        $data->owner_id = $user->id;

        $data->save();
        return $data;
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
        
        $this->validateData($request);

        $data = Reading::find($id);

        $data->title = $request->title;
        $data->description = $request->description;
        $data->data = $request->data;
        $data->genre_id = $request->genre_id;
        $data->difficulty = $request->difficulty;

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
        return Reading::find($id)->delete();
    }

    public function pageHome(){
        $user = Auth::user();
        
        return view('admin/readings', [
            'user' => $user,
        ]);
    }

    public function fetch(){
        $user = Auth::user();
        
        return Reading::all()
        ->when($user->role_id == '3', function ($query) use ($user) {
            return $query->where('owner_id', $user->id);
        });
    }
}
