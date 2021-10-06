@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Attendances</h4>
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
                <div class="card-block card-dashboard">
                    <p>List of your attendances ever since you joined us.</p>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-inverse">
                            <tr>
                                <th>#</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = 1;
                            @endphp
                            
                            @foreach($user->attendances as $attendance)

                            <tr>
                                <th scope="row">{{$count}}</th>
                                <td>{{($attendance->in ? \Carbon\Carbon::parse($attendance->in)->format('M d, Y l g:i A') : '-')}}</td>
                                <td>{{($attendance->out ? \Carbon\Carbon::parse($attendance->out)->format('M d, Y l g:i A') : '-')}}</td>
                            </tr>
                            
                            @php
                                $count++;
                            @endphp

                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
