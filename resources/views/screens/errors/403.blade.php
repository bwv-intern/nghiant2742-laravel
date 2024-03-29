@extends('layouts.admin')

@section('title', 'Admin')

@section('content')
    <div class="breadscrumb"><a href="{{ route('admin') }}">Top</a> > Permission denied</div>
    <div class="wrapper">
        <label class="title"> {{ $errorMsg }}</label>
   </div>
@stop