@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-xl-3 col-lg-6 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body text-xs-left">
                            <h3 class="pink"><span style="font-size: 14px;" class="text-bold-400"><date-time></date-time></span></h3>
                            <span>Date Today</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-calendar pink font-large-2 float-xs-right"></i>
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
                            <h3 class="teal">{{ \App\User::where('role_id', 2)->get()->count() }}</h3>
                            <span>Total Members</span>
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
                            <h3 class="deep-orange">{{ $data['attendedToday'] }}</h3>
                            <span>Attended Today</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-diagram deep-orange font-large-2 float-xs-right"></i>
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
                            <h3 class="cyan">{{ $data['reservedToday'] }}</h3>
                            <span>Reserved Today</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-ios-help-outline cyan font-large-2 float-xs-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row match-height">
    <div class="col-xl-4 col-lg-12">
        <div class="card" style="">
            <div class="card-body">
                <div class="media">
                    <div class="p-2 text-xs-center bg-deep-orange media-left media-middle">
                        <i class="icon-user1 font-large-2 white"></i>
                    </div>
                    <div class="p-2 media-body">
                        <h5 class="deep-orange">New Members</h5>
                        <h5 class="text-bold-400">{{$data['newMembers']}}</h5>
                        <progress class="progress progress-sm progress-deep-orange mt-1 mb-0" value="45" max="100"></progress>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="">
            <div class="card-body">
                <div class="media">
                    <div class="p-2 text-xs-center bg-cyan media-left media-middle">
                        <i class="icon-bicycle font-large-2 white"></i>
                    </div>
                    <div class="p-2 media-body">
                        <h5>Equipments</h5>
                        <h5 class="text-bold-400">{{ \App\Equipment::all()->count() }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="">
            <div class="card-body">
                <div class="media">
                    <div class="p-2 media-body text-xs-left">
                        <h5>Food Supplements</h5>
                        <h5 class="text-bold-400">{{ \App\FoodSupplement::all()->count() }}</h5>
                    </div>
                    <div class="p-2 text-xs-center bg-teal media-right media-middle">
                        <i class="icon-heartbeat font-large-2 white"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-xl-8 col-lg-12">
        <div class="card" style="">
            <div class="card-header">
                <h4 class="card-title">Reservations</h4>
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                        <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <reservations-component></reservations-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection