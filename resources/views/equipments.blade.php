@extends('layouts.admin')

@section('content')
    <equipments :user="{{$user}}"></equipments>
@endsection
