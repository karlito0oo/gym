@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-xl-3 col-lg-6 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="p-2 text-xs-center bg-cyan bg-darken-2 media-left media-middle">
                        <i class="icon-camera7 font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-cyan white media-body">
                        <h5>Member Since</h5>
                        <h5 class="text-bold-400">{{ $user->memberSince }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="p-2 text-xs-center bg-deep-orange bg-darken-2 media-left media-middle">
                        <i class="icon-user1 font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-deep-orange white media-body">
                        <h5>First Attend</h5>
                        <h5 class="text-bold-400">{{ $user->firstAttend }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="p-2 text-xs-center bg-teal bg-darken-2 media-left media-middle">
                        <i class="icon-cart font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-teal white media-body">
                        <h5>Last Attend</h5>
                        <h5 class="text-bold-400">{{ $user->lastAttend }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-xs-12">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="p-2 text-xs-center bg-pink bg-darken-2 media-left media-middle">
                        <i class="icon-banknote font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-pink white media-body">
                        <h5>Total Attended</h5>
                        <h5 class="text-bold-400">{{ $user->totalAttend }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- <equipments :user="{{$user}}"></equipments> -->
<!-- 
    <bmi-chart></bmi-chart> -->


    <div class="row">
       <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-block">
                        <canvas id="line-chart" height="500"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
