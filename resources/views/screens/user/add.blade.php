@extends('layouts.admin')

@section('title', 'Admin')
@vite(['resources/css/screens/user.css'])

@section('content')
    <div class="breadscrumb">
        <a href="{{ route('admin') }}">Top</a> > 
        <a href="{{ route('user') }}">Users</a> > 
        <a class="breadscrumb-active" disabled="disabled">Add</a>
    </div>
    <div class="wrapper">
        <div class="d-flex mb-5">
            <label class="title">User add</label>
        </div>
        <form action="{{ route('user.store') }}" method="POST" class="d-flex" id="addUserForm">
            @csrf
            <div class="row gx-0 w-100">
                <div class="col-6 ">
                    <x-input.common labelName='Email' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="email" name="email" id="email" value="{{ old('email') }}"/>

                    <x-input.common labelName='Password' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="password" name="password" id="password" value="{{ old('password') }}"/>

                    <x-input.select labelName='User flag' defaultValue="1" wrapStyle='inputUserElement' labelStyle='labelUserElement' name="user_flg" wrapStyle='inputUserElement' inputStyle='inputUserElement' :options="getArrayUserFlg()"/>

                    <x-input.common labelName='Date of birth' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="date" name="dateOfBirth" id="dateOfBirth" value="{{ old('dateOfBirth') }}"/>
                    
                    <x-input.textarea labelName='Address' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="textarea" name="address" id="address" value="{{ old('address')}}" rows="4"/>

                </div>
                
                <div class="col-6">
                    <x-input.common labelName='Full name' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="text" name="name" id="name" value="{{ old('name') }}"/>

                    <x-input.common labelName='Re-password' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="password" name="re_password" id="re_password" value="{{ old('re_password') }}"/>

                    <x-input.common labelName='Phone' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="text" name="phone" id="phone" value="{{ old('phone') }}"/>
                    
                </div>
                <div class="col-12 d-flex gap-2 justify-content-center">
                    <x-button.submit buttonName="Add" class="btn-custom btnSubmit"/>
                </div>
            </div>
        </form>
   </div>
@stop
@vite(['resources/js/screens/user.js'])