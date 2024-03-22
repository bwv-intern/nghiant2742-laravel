@extends('layouts.main')
@section('content')

<h1>Product</h1>

@if ($errors->any())
      <div class="mb-2">
        @foreach ($errors->all() as $error)
          <div class="alert alert-danger">
            {{ $error }}
          </div>
        @endforeach
      </div>
    @endif
<form action="/edit/{{ $product->id }}" method="post">
  @csrf
  @method('PUT')
  <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Quantity</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>

          <tr>
            <td>
              <div>{{ $product->id }}</div>
            </td>
            <td>
              <input type="text" name="name" value="{{ $product->name }}">
            </td>
            <td>
              <input type="text" name="quantity" value="{{ $product->quantity }}">
            </td>
            <td>
                <button type="submit" class="btn btn-primary">Submit</button>
            </td>
          </tr>

      </tbody>
    </table>
</form>
@endsection
