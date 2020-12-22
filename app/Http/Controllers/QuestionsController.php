<?php

namespace App\Http\Controllers;

use Auth;
use App\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
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
                'question' => 'required',
                'answer_1' => 'required',
                'answer_2' => 'required',
                'answer_3' => 'required',
                'answer_4' => 'required',
                'correct_answer' => 'required',
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
        $columns = ['question', 'answer_1', 'answer_2', 'answer_3', 'answer_4', 'correct_answer', 'difficulty'];

        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Question::select('*')
        ->when($user->role_id == '3', function ($query) use ($user) {
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
        $data = new Question();
        $data->question = $request->question;
        $data->answer_1 = $request->answer_1;
        $data->answer_2 = $request->answer_2;
        $data->answer_3 = $request->answer_3;
        $data->answer_4 = $request->answer_4;
        $data->correct_answer = $request->correct_answer;
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

        $data = Question::find($id);

        $data->question = $request->question;
        $data->answer_1 = $request->answer_1;
        $data->answer_2 = $request->answer_2;
        $data->answer_3 = $request->answer_3;
        $data->answer_4 = $request->answer_4;
        $data->correct_answer = $request->correct_answer;
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
        return Question::find($id)->delete();
    }

    public function pageHome(){
        $user = Auth::user();
        return view('admin/questions', [
            'user' => $user,
        ]);
    }

    public function fetch(){
        $user = Auth::user();
        
        return Question::all()
        ->when($user->role_id == '3', function ($query) use ($user) {
            return $query->where('owner_id', $user->id);
        });
    }
}
