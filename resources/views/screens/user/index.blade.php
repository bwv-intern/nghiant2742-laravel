@extends('layouts.admin')

@section('title', 'Admin')

@section('content')
    <div class="breadscrumb">
        <a href="{{ route('admin') }}">Top</a> > 
        <a class="breadscrumb-active" disabled="disabled">Users</a>
    </div>
    <div class="wrapper">
        <div class="d-flex justify-content-between mb-5">
            <label class="title">USERS SEARCH</label>
            <a class="btn btn-primary btnAddUser">Add user</a>
        </div>
        {{-- @if (session('oldQuery'))
            <h1>{{ json_encode(session('oldQuery')) }}</h1>
        @endif --}}
        <form action="{{ route('user') }}" method="GET" class="d-flex" id="userSearchForm">
            <div class="row gx-0 w-100">
                <div class="col-6 ">
                    <div class="inputUserElement">
                        <label for="email" class="labelUserElement">Email</label>
                        <div class="d-flex flex-column">
                            <x-input type="email" name="email" id="email" value="{{ old('email') }}" />
                        </div>
                    </div>
                    <div class="inputUserElement">
                        <label class="labelUserElement">User flag</label>
                        <div class="inputUserElement-checkbox">
                            <x-input type="checkbox" id="adminFlag" name="user_flg[]" value="0" checked/>
                            <label for="adminFlag">Admin</label>
                            <x-input type="checkbox" id="userFlag" name="user_flg[]" value="1" checked/>
                            <label for="userFlag">User</label>
                            <x-input type="checkbox" id="supportFlag" name="user_flg[]" value="2" checked/>
                            <label for="supportFlag">Support</label>
                        </div>
                    </div>
                    <div class="inputUserElement">
                        <label for="dateOfBirth" class="labelUserElement">Date of birth</label>
                        <div class="d-flex flex-column">
                            <x-input type="date" name="dateOfBirth" id="dateOfBirth" value="{{ old('dateOfBirth') }}" />
                        </div>
                    </div>
                </div>
                
                <div class="col-6">
                    <div class="inputUserElement">
                        <label for="name" class="labelUserElement">Full name</label>
                        <div class="d-flex flex-column">
                            <x-input type="text" name="name" id="name" value="{{ old('name') }}" />
                        </div>
                    </div>
                    <div class="inputUserElement">
                        <label for="phone" class="labelUserElement">Phone</label>
                        <div class="d-flex flex-column">
                            <x-input type="text" name="phone" id="phone" value="{{ old('phone') }}" />
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex gap-2 justify-content-end">
                    <button class="btn-custom" type="submit" id="btnSearchUser">Search</button>
                    <button class="btn-custom" type="reset">Clear</button>
                    <button class="btn-custom">Export CSV</button>
                </div>
            </div>
        </form>
   </div>
   <div class="wrapper">
    <div class="d-flex justify-content-between align-items-end mt-5 mb-2">
        <label>Showing 1 to 10 of {{ count($users) }} entries</label>

        <form class="d-flex gap-1" action="{{ route('user') }}" method="GET" id="paginationForm">
            <button class="btn btn-light border" type="submit" data-page="1">First</button>
            <button class="btn btn-light border"><</button>
            <button class="btn btn-light border">1</button>
            <button class="btn btn-light border">2</button>
            <button class="btn btn-light border">3</button>
            <button class="btn btn-light border">4</button>
            <button class="btn btn-light border">></button>
            <button class="btn btn-light border" type="submit" data-page="10">Last</button>
        </div>
    </div>
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
                    <td scope="row" class="itemTable">{{ $user['user_flg'] }}</td>
                    <td scope="row" class="itemTable">{{ $user['date_of_birth'] }}</td>
                    <td scope="row" class="itemTable">{{ $user['phone'] }}</td>
                    <td scope="row" class="itemTable">{{ $user['address'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
   </div>
   {{-- Table of users --}}

@stop
@vite(['resources/js/screens/user.js'])