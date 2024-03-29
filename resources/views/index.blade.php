@extends('layouts.admin')

@section('title', 'Admin')

@section('content')
    @if (session('msgError'))
        <x-toast msg="{{ session('msgError') }}"/>
    @endif
    <span>
        <a class="breadscrumb-active" disabled="disabled">Top</a>
    </span>
    <div class="wrapper">
        <label class="title">TOP</label>
    </div>
@stop