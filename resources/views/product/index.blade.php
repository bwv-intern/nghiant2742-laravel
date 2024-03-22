@extends('layouts.main')
@section('content')

<h1>Product</h1>
<a href="{{ route('product.add') }}" class="btn btn-primary">Add</a>
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
      @foreach ($products as $product)
        <tr>
          <td>{{ $product->id }}</td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->quantity }}</td>
          <td class="d-flex gap-2">
              <a class="btn btn-primary" href="/edit/{{ $product->id }}">Edit</a>
              <form action="/delete/{{ $product->id }}" method="post">
                @csrf
                @method('delete')
                <button class="btn btn-danger" type="submit">Delete</button>
              </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  @for ($i = 1; $i <= $pageNumber; $i++)
    <a href="?page={{ $i }}">{{ $i }}</a>
  @endfor
@endsection
