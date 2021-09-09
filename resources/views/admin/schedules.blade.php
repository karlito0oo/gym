@extends('layouts.admin');

@section('content')
<div class="row">
    
    <div class="col-xl-3 col-lg-6 col-xs-12">
        <div class="card bg-blue">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body white text-xs-right">
                            <center><h3>Available</h3></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($user->role->name == 'admin')
        <div class="col-xl-3 col-lg-6 col-xs-12">
            <div class="card bg-purple">
                <div class="card-body">
                    <div class="card-block">
                        <div class="media">
                            <div class="media-body white text-xs-right">
                                <center><h3>Have Pending Reservation</h3></center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-xl-3 col-lg-6 col-xs-12">
            <div class="card bg-pink">
                <div class="card-body">
                    <div class="card-block">
                        <div class="media">
                            <div class="media-body white text-xs-right">
                                <center><h3>Pending Reservation</h3></center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6 col-xs-12">
            <div class="card bg-green">
                <div class="card-body">
                    <div class="card-block">
                        <div class="media">
                            <div class="media-body white text-xs-right">
                                <center><h3>Approved Reservation</h3></center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    
    <div class="col-xl-3 col-lg-6 col-xs-12">
        <div class="card bg-red">
            <div class="card-body">
                <div class="card-block">
                    <div class="media">
                        <div class="media-body white text-xs-right">
                            <center><h3>Fully Booked</h3></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>


<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">SCHEDULES</h4>
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
                    <calendar :user="{{$user}}"></calendar>
            </div>
        </div>
    </div>
</div>


@endsection
