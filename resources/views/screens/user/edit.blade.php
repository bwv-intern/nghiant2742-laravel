@extends('layouts.admin')

@section('title', 'Admin')
@vite(['resources/css/screens/user.css'])

@section('content')
    <div class="breadscrumb">
        <a href="{{ route('admin') }}">Top</a> > 
        <a href="{{ route('user') }}">Users</a> > 
        <a class="breadscrumb-active" disabled="disabled">Edit</a>
    </div>
    <div class="wrapper">
        <div class="d-flex mb-5">
            <label class="title">User edit</label>
        </div>
        <form action="{{ route('user.update', $user['id']) }}" method="POST" class="d-flex" id="updateUserForm">
            @csrf
            @method('put')
            <div class="row gx-0 w-100">
                <div class="col-6 ">
                    <x-input.common labelName='Email' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="email" name="email" id="email" value="{{ old('email') ?? $user['email'] }}"/>

                    <x-input.common labelName='Password' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="password" name="password" id="password"/>

                    <x-input.select labelName='User flag' defaultValue="{{ old('user_flg') ?? $user['user_flg'] }}" wrapStyle='inputUserElement' labelStyle='labelUserElement' name="user_flg" wrapStyle='inputUserElement' inputStyle='inputUserElement' :options="getArrayUserFlg()"/>

                    <x-input.common labelName='Date of birth' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') ?? $user['date_of_birth'] }}"/>
                    
                    <x-input.textarea labelName='Address' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="textarea" name="address" id="address" value="{{ $user['address']}}" rows="4"/>

                </div>
                
                <div class="col-6">
                    <x-input.common labelName='Full name' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="text" name="name" id="name" value="{{ $user['name'] }}"/>

                    <x-input.common labelName='Re-password' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="password" name="re_password" id="re_password" value="{{ $user['re_password'] }}"/>

                    <x-input.common labelName='Phone' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="text" name="phone" id="phone" value="{{ old('phone') ?? $user['phone'] }}"/>
                    
                </div>
                <div class="col-12 d-flex gap-2 justify-content-center">
                    <x-button.submit buttonName="Update" class="btn-custom"/>
                </div>
            </div>
        </form>
   </div>
@stop
@vite(['resources/js/screens/user/edit.js'])