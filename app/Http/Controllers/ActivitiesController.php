<?php

namespace App\Http\Controllers;

use Auth;
use App\Activity;
use App\User;
use App\Question;
use App\ActivityUserAnswer;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
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
        $validator = [
            'name' => 'required',
            'type' => 'required',
            'dateStart' => 'required',
            'dateEnd' => 'required',
            'sections' => 'required',
            'dateStartTime' => 'required',
            'dateEndTime' => 'required',
        ];
        if($request->type == 'Reading Comprehension'){
            $validator['readings'] = 'required';
        }
        else{
            $validator['questions'] = 'required';
        }
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
        $columns = ['name', 'type', 'dateStart', 'dateEnd'];

        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Activity::select('activities.*')
        ->with('sections')
        ->with('questions')
        ->with('readings')
        ->with('readers')
        ->with('answered')
        ->when($user->role_id == '3', function ($query) use ($user) {
            return $query->where('owner_id', $user->id);
        })
        ->when($user->role_id == '1', function ($query) use ($user) {
            return $query->join('activity_section', 'activities.id', '=', 'activity_section.activity_id')
                ->where('activity_section.section_id', $user->section_id);
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
        $this->validateData($request);

        $user = Auth::user();
        $data = new Activity();
        $data->name = $request->name;
        $data->type = $request->type;
        $data->dateStart = $request->dateStart;
        $data->dateEnd = $request->dateEnd;
        $data->owner_id = $user->id;
        $data->dateStartTime = $request->dateStartTime;
        $data->dateEndTime = $request->dateEndTime;
        $data->save();
        
        $data->sections()->attach($request->sections);
        
        if($request->type == 'Reading Comprehension'){
            $readings_id = array_column($request->readings, 'id');
            $data->readings()->attach($readings_id);
        }
        else{
            $questions = array_column($request->questions, 'id');
            $data->questions()->attach($questions);
        }
        

        
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
        $user = Auth::user();
        $activity = Activity::select('*')
            ->with('questions')
            ->with('readings')
            ->where('id', $id)
            ->first();

        if($activity->type == 'Reading Comprehension'){
            $activity->readers()->attach($user->id);
            return view('student/reading-comprehension', [
                'activity' => $activity,
            ]);
        }
        else{
            return view('student/answer-activity', [
                'activity' => $activity,
            ]);
        }
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

        $data = Activity::find($id);

        $data->name = $request->name;
        $data->type = $request->type;
        $data->dateStart = $request->dateStart;
        $data->dateEnd = $request->dateEnd;
        $data->dateStartTime = $request->dateStartTime;
        $data->dateEndTime = $request->dateEndTime;
        $data->save();

        $data->sections()->sync($request->sections);

        if($request->type == 'Reading Comprehension'){
            $readings_id = array_column($request->readings, 'id');
            $data->readings()->sync($readings_id);
        }
        else{
            $questions = array_column($request->questions, 'id');
            $data->questions()->sync($questions);
        }

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Activity::find($id)->delete();
    }

    public function pageHome(){
        $user = Auth::user();
        return view('admin/activities', [
            'user' => $user,
        ]);
    }

    public function submitAnswers(Request $request){
        $user = Auth::user();
        $activity_id = $request->activity_id;
        $activity = Activity::find($activity_id);

        unset($request['activity_id']);
        unset($request['_token']);
        //save answers
        foreach($request->request as $key => $value){
            $answerDetails = explode(',', $value);
            $data = new ActivityUserAnswer();
            $data->activity_id = $activity_id;
            $data->question_id = $answerDetails[0];
            $data->answer = $answerDetails[1];
            $data->user_id = $user->id;
            $data->save();
        }
        return $this->activityResult($activity_id, $user->id);
    }

    public function activityResult($activity_id, $user_id){
        $user = User::find($user_id);
        $activity = Activity::find($activity_id);
        $result = $this->checkAnswers($activity_id, $user->id);
        return view('student/activity-result', [
            'user' => $user,
            'result' => $result,
            'activity' => $activity
        ]);
    }

    public function checkAnswers($activity_id, $user_id){
        $answers = ActivityUserAnswer::where('activity_id', $activity_id)
                        ->where('user_id', $user_id)
                        ->get();
        $data['over'] = count($answers);
        $data['score'] = 0;

        foreach($answers as $answer){
            $question = Question::find($answer->question_id);
            if($question->correct_answer == $answer->answer){
                $data['score']++;
            }
        }
        
        return $data;
    }

    public function isAnswered(Request $request){
        $user = Auth::user();
        return ActivityUserAnswer::where('activity_id', $request->id)->where('user_id', $user->id)->get();
    }
}
