@extends('layouts.admin')

@section('title', 'Admin')
@vite(['resources/css/screens/user.css'])

@section('content')
    <div class="breadscrumb">
        <a class="link" href="{{ route('admin') }}">Top</a> > 
        <a class="breadscrumb-active" disabled="disabled">Users</a>
    </div>
    <div class="wrapper">
        <div class="d-flex justify-content-between mb-5">
            <label class="title">User search</label>
            <a class="btn btn-primary btnAddUser" href="{{ route('user.add') }}">Add user</a>
        </div>
        
        <form action="{{ route('user') }}" method="GET" class="d-flex" id="userSearchForm">
            <div class="row gx-0 w-100">
                <div class="col-12 col-lg-6">
                    <x-input.common labelName='Email' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="email" name="email" id="email" value="{{ Session::get('userQueryParams')['email'] ?? '' }}"/>

                    <x-input.checkbox labelName='User flag' wrapStyle='inputUserElement' labelStyle='labelUserElement' name="user_flg" wrapStyle='inputUserElement' inputStyle='inputUserElement-checkbox' :options="isCheckedBox(Session::get('userQueryParams')['user_flg'] ?? null)"/>

                    <x-input.common labelName='Date of birth' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="date" name="date_of_birth" id="date_of_birth" value="{{ Session::get('userQueryParams')['date_of_birth'] ?? '' }}"/>
                    
                </div>
                
                <div class="col-12 col-lg-6">
                    <x-input.common labelName='Full name' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="text" name="name" id="name" value="{{ Session::get('userQueryParams')['name'] ?? '' }}"/>

                    <x-input.common labelName='Phone' wrapStyle='inputUserElement' labelStyle='labelUserElement' type="text" name="phone" id="phone" value="{{ Session::get('userQueryParams')['phone'] ?? '' }}"/>
                    
                </div>
                <div class="col-12 d-flex flex-wrap gap-2 justify-content-end">
                    <x-button.submit id="btnSearchUser" buttonName="Search" class="btn-custom btn col-12 col-lg-2"/>
                    <x-button.common id="btnClear" name="clear" buttonName="Clear" class="btn-custom btn col-12 col-lg-2" value="true"/>
                    <x-button.common id="btnExport" data-target="{{ route('user.export') }}" buttonName="Export CSV" class="btn-custom btn col-12 col-lg-2"/>
                    <x-button.common buttonName="Import CSV" class="btn-custom col-12 col-lg-2" data-bs-toggle="modal" data-bs-target="#importModal"/>
                </div>
            </div>
        </form>
   </div>
   @if (count($users)!==0)

            {{ $users->links('components.paginateCustom') }}
            {{-- Table of users --}}
            <div class="table-responsive">
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
                                    <a class="btn btn-primary" style="min-width: 70px" href="{{ route('user.edit', $user['id']) }}">Edit</a>
                                    <form id="deleteForm_{{ $user['id'] }}" action="{{ route('user.delete', $user['id']) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <x-button.submit buttonName="Delete" class="btn btn-danger deleteBtn" data-id="{{ $user['id'] }}" />
                                    </form>
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
   
<!-- Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="importModalLabel">Import CSV</h5>
          <x-button.common buttonName="" data-bs-dismiss="modal" class="btn-close" aria-label="Close"/>
        </div>
        <div class="modal-body">
            <form action="{{ route('user.import') }}" method="post" enctype="multipart/form-data" id="importForm">
                @csrf
                <div class="text-left d-flex flex-column">
                    {{-- <input type="file" name="csv_file" class="" id="customFile"> --}}
                    <x-input.common type="file" name="csv_file" class="" id="customFile"/>
                    
                </div>
                <div class="modal-footer" style="border-top: none">
                  <x-button.common buttonName="Close" data-bs-dismiss="modal" class="btn btn-secondary"/>
                  <x-button.submit buttonName="Submit" class="btn btn-primary"/>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
@stop
@vite(['resources/js/screens/user/search.js', 'resources/js/screens/user/import.js', 'resources/js/screens/user/export.js'])