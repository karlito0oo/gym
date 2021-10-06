@extends('layouts.admin')

@section('content')
    <my-profile :user="{{$user}}"></my-profile>
@endsection
