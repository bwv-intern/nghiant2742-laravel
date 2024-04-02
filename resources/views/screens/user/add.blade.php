@extends('layouts.admin')

@section('title', 'Admin')

@section('content')
    <div class="breadscrumb">
        <a href="{{ route('admin') }}">Top</a> > 
        <a href="{{ route('user') }}">Users</a> > 
        <a class="breadscrumb-active" disabled="disabled">Add</a>
    </div>
    <div class="wrapper">
        <div class="d-flex mb-5">
            <label class="title">USERS ADD</label>
        </div>
        
        <form action="{{ route('user') }}" method="GET" class="d-flex" id="userSearchForm">
            <div class="row gx-0 w-100">
                <div class="col-6 ">
                    <x-input.common labelName='Email' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="email" name="email" id="email" value="{{ Session::get('queryParams')['email'] ?? '' }}"/>

                    <x-input.checkbox labelName='User flag' wrapStyle='inputUserElement' labelStyle='labelUserElement' name="user_flg" wrapStyle='inputUserElement' inputStyle='inputUserElement-checkbox' :options="isCheckedBox(Session::get('queryParams')['user_flg'] ?? null)"/>

                    <x-input.common labelName='Date of birth' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="date" name="dateOfBirth" id="dateOfBirth" value="{{ Session::get('queryParams')['dateOfBirth'] ?? '' }}"/>
                    
                </div>
                
                <div class="col-6">
                    <x-input.common labelName='Full name' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="text" name="name" id="name" value="{{ Session::get('queryParams')['name'] ?? '' }}"/>

                    <x-input.common labelName='Phone' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="text" name="phone" id="phone" value="{{ Session::get('queryParams')['phone'] ?? '' }}"/>
                    
                </div>
                <div class="col-12 d-flex gap-2 justify-content-end">
                    <x-button.submit id="btnSearchUser" buttonName="Add" class="btn-custom btnSubmit"/>
                </div>
            </div>
        </form>
   </div>

@stop
@vite(['resources/js/screens/user.js'])