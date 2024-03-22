@extends('layouts.main')
@section('content')

<h1>Product </h1>

<h3> Id: {{ $product->id }}</h3>
<h3> Name: {{ $product->name }}</h3>
<h3> Name: {{ $product->quantity }}</h3>
@endsection
