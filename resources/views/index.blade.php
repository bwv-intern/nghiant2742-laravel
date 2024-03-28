@extends('layouts.admin')

@section('title', 'Admin')

@section('content')
    @if (session('msgError'))
        <div class="toastMsg">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('msgError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
    <span>
        <a class="breadscrumb-active" disabled="disabled">Top</a>
    </span>
    <div class="wrapper">
        <label class="title">TOP</label>
    </div>
@stop