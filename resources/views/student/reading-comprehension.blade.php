@extends("layouts.student");

@section('content')

@foreach($activity->readings as $reading)
    <section id="global-settings" class="card">
        <div class="card-header">
            <h4 class="card-title">{{ $reading->title }}</h4>
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
            <div class="card-block">
                <div class="card-text">
                    <small>{{ $reading->description }}</small>
                    <br><br>
                    {!! $reading->data !!}
                </div>
            </div>
        </div>
    </section>
@endforeach

@endsection
