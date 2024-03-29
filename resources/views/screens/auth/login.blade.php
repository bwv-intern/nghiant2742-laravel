@extends('layouts.master')

@section('title', 'Admin login')

@section('content')
    <div class="containerLogin">
        @if (session('errorMsg'))
            <x-toast msg="{{ session('errorMsg') }}"/>
        @endif
        @if ($errors->any())
            <div class="toastMsg">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->all()[0] }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <form action="{{ route('login') }}" method="post" id="loginForm">
            @csrf
            <div>
                <label for="email" class="d-flex justify-content-end">Email</label>
                <div class="group-input">
                    <x-input type="email" name="email" id="email" value="{{ old('email') }}" />
                </div>
            </div>
            <div>
                <label for="password">Password</label>
                <div class="group-input">
                    <x-input type="password" name="password" id="password" value="{{ old('password') }}"/>
                </div>
            </div>
            <button type="submit" id="btnLogin">
                Login
            </button>
        </form>
   </div>
@stop