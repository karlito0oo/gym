@extends('layouts.instructor')

@section('content')
<div class="row">
    <div class="col-xl-3 col-lg-6 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body text-xs-left">
                            <h3 class="pink">{{ count($data['activities']) }}</h3>
                            <span>Activities</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-bag2 pink font-large-2 float-xs-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body text-xs-left">
                            <h3 class="teal">{{ count($data['students']) }}</h3>
                            <span>Students</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-user1 teal font-large-2 float-xs-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body text-xs-left">
                            <h3 class="deep-orange">{{ count($data['questions']) }}</h3>
                            <span>Questions</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-question deep-orange font-large-2 float-xs-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body text-xs-left">
                            <h3 class="cyan">{{ count($data['readingComprehensions']) }}</h3>
                            <span>Reading Comprehensions</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-book cyan font-large-2 float-xs-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ stats -->
<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Ongoing activities</h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body collapse in">
                <div class="card-block">
                    <table class="table">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Sections</th>
                                <th>Answered Student</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($data['ongoingActivities']) == 0)
                            <tr>
                                <td colspan="4" style="text-align:center;"> No data found.</td>
                            </tr>
                            @endif
                            @foreach($data['ongoingActivities'] as $activity)
                            <tr>
                                <td>{{$activity->name}}</td>
                                <td>{{$activity->type}}</td>
                                <td>
                                    @foreach($activity->sections as $section)
                                        <li>{{ $section->name }}</li>
                                    @endforeach
                                </td>
                                <td>{{count($activity->answered)}} / {{count($activity->takers())}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Calendar</h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body collapse in">
                <calendar></calendar>
            </div>
        </div>
    </div>
</div>
@endsection
