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
        <form action="{{ route('user') }}" method="post" class="d-flex" id="userSearchForm">
            @csrf
            <div class="row gx-0 w-100">
                <div class="col-5 ">
                    <div class="inputUserElement">
                        <label for="email" class="labelUserElement">Email</label>
                        <div class="">
                            <x-input type="email" name="email" id="email" value="{{ old('email') }}" />
                        </div>
                    </div>
                    <div class="inputUserElement">
                        <label class="labelUserElement">User flag</label>
                        <div class="inputUserElement-checkbox">
                            <x-input type="checkbox" name="adminFlag" value="0" />
                            <label for="adminFlag">Admin</label>
                            <x-input type="checkbox" name="userFlag" value="1" />
                            <label for="userFlag">User</label>
                            <x-input type="checkbox" name="supportFlag" value="2" />
                            <label for="supportFlag">Support</label>
                        </div>
                    </div>
                    <div class="inputUserElement">
                        <label for="date" class="labelUserElement">Date</label>
                        <div class="">
                            <x-input type="date" name="date" id="date" value="{{ old('date') }}" />
                        </div>
                    </div>
                </div>
                <div class="col-2"></div>
                <div class="col-5 ">
                    <div class="inputUserElement">
                        <label for="fullname" class="labelUserElement">Full name</label>
                        <div class="">
                            <x-input type="text" name="fullname" id="fullname" value="{{ old('fullname') }}" />
                        </div>
                    </div>
                    <div class="inputUserElement">
                        <label for="phone" class="labelUserElement">Phone</label>
                        <div class="">
                            <x-input type="text" name="phone" id="phone" value="{{ old('phone') }}" />
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex gap-2 justify-content-end">
                    <button class="btn-custom" type="submit">Search</button>
                    <button class="btn-custom" type="reset">Clear</button>
                    <button class="btn-custom">Export CSV</button>
                </div>
            </div>
        </form>
   </div>
@stop