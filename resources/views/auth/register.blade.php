@extends('layouts.main')
@section('content')
<section class="col-5 mx-auto">
  @if ($errors->any())
      <div class="mb-2">
        @foreach ($errors->all() as $error)
          <div class="alert alert-danger">
            {{ $error }}
          </div>
        @endforeach
      </div>
    @endif
  <form method="POST" action="{{ route('register') }}">
    @csrf
    <!-- Name input -->
    <div class="form-outline mb-4">
      <label class="form-label">Name</label>
      <input type="text" class="form-control" name="name"/>
    </div>

    <!-- Email input -->
    <div class="form-outline mb-4">
      <label class="form-label">Email address</label>
      <input type="email" class="form-control" name="email"/>
    </div>
  
    <!-- Password input -->
    <div class="form-outline mb-4">
      <label class="form-label">Password</label>
      <input type="password" class="form-control" name="password"/>
    </div>

    <!-- Password input -->
    <div class="form-outline mb-4">
      <label class="form-label">Confirm Password</label>
      <input type="password" class="form-control" name="password_confirmation"/>
    </div>
    
    <!-- Submit button -->
    <button type="submit" class="btn btn-primary w-100 mb-4 text-center">Sign up</button>
  
    <!-- Register buttons -->
    <div class="text-center">
      <p>Already a member? <a href="{{ route('login') }}">Login</a></p>
      
  </form>
</section>
@endsection
