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
            <x-input type="email" labelName="Email" name="email" id="email" value="{{ old('email') }}" />
            <x-input type="password" labelName="Password" name="password" id="password" value="{{ old('password') }}"/>
            <x-button type="submit" id="btnLogin" showName="Login" class="btnSubmit"/>
        </form>
   </div>
@stop