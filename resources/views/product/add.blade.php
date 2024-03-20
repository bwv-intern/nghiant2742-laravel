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
<form action="{{ route('product.add') }}" method="post">
  @csrf
  <table class="table">
      <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Quantity</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>

          <tr>
            <td>
              <input type="text" name="name">
            </td>
            <td>
              <input type="text" name="quantity">
            </td>
            <td>
                <button type="submit" class="btn btn-primary">Submit</button>
            </td>
          </tr>

      </tbody>
    </table>
</form>
@endsection
