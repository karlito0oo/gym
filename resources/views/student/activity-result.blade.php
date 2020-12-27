@extends("layouts.student");

@section('content')
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
				<h3 class="mb-0">Score :{{$result['score']}} / {{$result['over']}}</h3>
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
                                        <div class="col-md-3" style="{{($question->correct_answer == 'answer_1' ? 'background-color:green; font-weight:bold;' : '')}}">
                                            <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="question_id={{$question->id}}" class="custom-control-input"
                                                value="{{$question->id}},answer_1" required
                                                {{ ($question->user_answer($activity->id, $user->id) == 'answer_1' ? 'checked' : '') }}>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0" style="{{($question->correct_answer == 'answer_1' ? 'color:white;' : '')}}">{{ $question->answer_1 }}</span>
                                            </label>
                                        </div>

                                        <div class="col-md-3" style="{{($question->correct_answer == 'answer_2' ? 'background-color:green; font-weight:bold;' : '')}}">
                                            <label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="question_id={{$question->id}}" class="custom-control-input"
                                                value="{{$question->id}},answer_2" required
                                                {{ ($question->user_answer($activity->id, $user->id) == 'answer_2' ? 'checked' : '') }}>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0" style="{{($question->correct_answer == 'answer_2' ? 'color:white;' : '')}}">{{ $question->answer_2 }}</span>
                                            </label>
                                        </div>
                                        <div class="col-md-3" style="{{($question->correct_answer == 'answer_3' ? 'background-color:green; font-weight:bold;' : '')}}">
                                            <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="question_id={{$question->id}}" class="custom-control-input"
                                                value="{{$question->id}},answer_3" required
                                                {{ ($question->user_answer($activity->id, $user->id) == 'answer_3' ? 'checked' : '') }}>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0" style="{{($question->correct_answer == 'answer_3' ? 'color:white;' : '')}}">{{ $question->answer_3 }}</span>
                                            </label>
                                        </div>

                                        <div class="col-md-3" style="{{($question->correct_answer == 'answer_4' ? 'background-color:green; font-weight:bold;' : '')}}">
                                            <label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="question_id={{$question->id}}" class="custom-control-input"
                                                value="{{$question->id}},answer_4" required
                                                {{ ($question->user_answer($activity->id, $user->id) == 'answer_4' ? 'checked' : '') }}>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0" style="{{($question->correct_answer == 'answer_4' ? 'color:white;' : '')}}">{{ $question->answer_4 }}</span>
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
    </section>
    <div class="modal fade text-xs-left in" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" style="padding-right: 17px;">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel18"><i class="icon-android-bar"></i> Activity Result</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" role="alert">
                    <span class="text-bold-600">Well done!</span> You successfully answered this activity.
                </div>
                <h5><i class="icon-arrow-right-c"></i> You score: {{$result['score']}} / {{$result['over']}}</h5>
                <hr>
                <h5><i class="icon-lightbulb-o"></i> Tips</h5>
                <p>You can review you answer after closing this modal. The checeked answer was your answer and the choice that have green background is the correct answer.</p>
                
            </div>
            <div class="modal-footer">
            <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
@endsection
<script>
window.onload = function() {
  $('#resultModal').modal('show');
}
</script>