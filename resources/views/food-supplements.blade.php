@extends('layouts.admin')

@section('content')
    <food-supplements :user="{{$user}}"></food-supplements>
@endsection
