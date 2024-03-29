@extends('layouts.admin')

@section('title', 'Admin')

@section('content')
    <div class="breadscrumb">
        <a href="{{ route('admin') }}">Top</a> > 
        <a class="breadscrumb-active" disabled="disabled">Users</a>
    </div>
    <div class="wrapper">
        <label class="title">USERS</label>
   </div>
@stop