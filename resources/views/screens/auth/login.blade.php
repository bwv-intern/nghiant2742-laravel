@extends('layouts.master')

@section('title', 'Admin login')

@section('content')
    <div class="containerLogin">
        @if (session('errorMsg'))
            <x-toast msg="{{ session('errorMsg') }}" type="danger"/>
        @endif
        @if ($errors->any())
            <x-toast msg="{{ $errors->all()[0] }}" type="danger"/>
        @endif

        <form action="{{ route('login') }}" method="post" id="loginForm">
            @csrf
            <x-input.common inputStyle="group-input" type="email" labelName="Email" name="email" id="email" value="{{ old('email') }}" />
            <x-input.common inputStyle="group-input" type="password" labelName="Password" name="password" id="password" value="{{ old('password') }}"/>
            <x-button.submit id="btnLogin" buttonName="Login" class="btnSubmit"/>
        </form>
   </div>
@stop