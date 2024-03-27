@extends('layouts.master')

@section('title', 'Admin login')

@section('content')
    <div class="containerLogin">
        @if (session('errorMsg'))
            <div class="toastMsg">
                <div class="alert alert-danger">
                    {{ session('errorMsg') }}
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div class="toastMsg">
                <div class="alert alert-danger">
                    {{ $errors->all()[0] }}
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