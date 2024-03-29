@extends('layouts.admin')

@section('title', 'Admin')

@section('content')
    <div class="breadscrumb"><a href="{{ route('admin') }}">Top</a> > Not Found</div>
    <div class="wrapper">
        <label class="title"> {{ $errorMsg }}</label>
   </div>
@stop