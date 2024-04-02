@extends('layouts.admin')

@section('title', 'Admin')

@section('content')
    @if ($errors->any())
        <x-toast msg="{{ $errors->all()[0] }}" type="danger"/>
    @endif
    @if (isset($msgInfo))
        <x-toast msg="{{$msgInfo}}" type="info"/>
    @endif
    <div class="breadscrumb">
        <a href="{{ route('admin') }}">Top</a> > 
        <a class="breadscrumb-active" disabled="disabled">Users</a>
    </div>
    <div class="wrapper">
        <div class="d-flex justify-content-between mb-5">
            <label class="title">USERS SEARCH</label>
            <a class="btn btn-primary btnAddUser" href="{{ route('user.add') }}">Add user</a>
        </div>
        
        <form action="{{ route('user') }}" method="GET" class="d-flex" id="userSearchForm">
            <div class="row gx-0 w-100">
                <div class="col-6 ">
                    <x-input.common labelName='Email' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="email" name="email" id="email" value="{{ Session::get('userQueryParams')['email'] ?? '' }}"/>

                    <x-input.checkbox labelName='User flag' wrapStyle='inputUserElement' labelStyle='labelUserElement' name="user_flg" wrapStyle='inputUserElement' inputStyle='inputUserElement-checkbox' :options="isCheckedBox(Session::get('userQueryParams')['user_flg'] ?? null)"/>

                    <x-input.common labelName='Date of birth' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="date" name="dateOfBirth" id="dateOfBirth" value="{{ Session::get('userQueryParams')['dateOfBirth'] ?? '' }}"/>
                    
                </div>
                
                <div class="col-6">
                    <x-input.common labelName='Full name' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="text" name="name" id="name" value="{{ Session::get('userQueryParams')['name'] ?? '' }}"/>

                    <x-input.common labelName='Phone' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="text" name="phone" id="phone" value="{{ Session::get('userQueryParams')['phone'] ?? '' }}"/>
                    
                </div>
                <div class="col-12 d-flex gap-2 justify-content-end">
                    <x-button.submit id="btnSearchUser" buttonName="Search" class="btn-custom"/>
                    <x-button.submit id="btnClear" name="clearForm" buttonName="Clear" class="btn-custom"/>
                    <a class="btn-custom" href="{{ route('user.export') }}">Export CSV</a>
                </div>
            </div>
        </form>
   </div>
   @if (count($users)!==0)
    <div class="wrapper">
            {{-- <x-paginateCustom :users="$users"/> --}}
            {{ $users->links('components.paginateCustom') }}
            {{-- Table of users --}}
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th scope="col"></th>
                        <th scope="col">Email</th>
                        <th scope="col">Full name</th>
                        <th scope="col">User flag</th>
                        <th scope="col">Date of birth</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td scope="row">
                                    <button class="btn btn-primary">Edit</button>
                                    <button class="btn btn-danger">Delete</button>
                                </td>
                                <td scope="row" class="itemTable">{{ $user['email'] }}</td>
                                <td scope="row" class="itemTable">{{ $user['name'] }}</td>
                                <td scope="row" class="itemTable">{{ parseRole($user['user_flg']) }}</td>
                                <td scope="row" class="itemTable">{{ $user['date_of_birth'] }}</td>
                                <td scope="row" class="itemTable">{{ $user['phone'] }}</td>
                                <td scope="row" class="itemTable">{{ $user['address'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    @endif
   

@stop
@vite(['resources/js/screens/user.js'])