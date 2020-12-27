@extends("layouts.student");

@section('content')
<form action="{{ url('home/activities/submit-answers') }}" method="post" >
    @csrf
    <section id="global-settings" class="card">
        <div class="card-header">
            <h4 class="card-title">{{{ $activity->name }}}</h4>
            <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                    <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                    <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                    <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-body collapse in">
            <div class="m-1">
				<h3 class="mb-0">Questions:</h3>
                <small style="color:red;">Note: Once you submit your answer, you cannot edit it.</small>
                <input type="hidden" name="activity_id" value="{{$activity->id}}">
			</div>
            <div class="card">
            @foreach($activity->questions as $question)
				<div id="headingCollapse1" class="card-header">
					<a data-toggle="collapse" href="#question-collapse-{{$question->id}}" aria-expanded="true" aria-controls="collapse1" class="card-title lead">{{ $question->question }}</a>
				</div>
				<div id="question-collapse-{{$question->id}}" role="tabpanel" aria-labelledby="headingCollapse1" class="card-collapse collapse in" aria-expanded="true">
					<div class="card-body">
						<div class="card-block">
                                
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="question_id={{$question->id}}" class="custom-control-input" 
                                                value="{{$question->id}},answer_1" required>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">{{ $question->answer_1 }}</span>
                                            </label>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="question_id={{$question->id}}" class="custom-control-input"  
                                                value="{{$question->id}},answer_2" required>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">{{ $question->answer_2 }}</span>
                                            </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="question_id={{$question->id}}" class="custom-control-input" 
                                                value="{{$question->id}},answer_3" required>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">{{ $question->answer_3 }}</span>
                                            </label>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="question_id={{$question->id}}" class="custom-control-input" 
                                                value="{{$question->id}},answer_4" required>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">{{ $question->answer_4 }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
						</div>
					</div>
				</div>
            @endforeach
			</div>
        </div>
        <div class="form-actions m-2">
            <button type="submit" class="btn btn-primary">
                <i class="icon-check2"></i> Submit
            </button>
        </div>
    </section>

</form>
@endsection
