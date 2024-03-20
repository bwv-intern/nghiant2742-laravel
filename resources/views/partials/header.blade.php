<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">Demo</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="/posts">Posts</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/product">Product</a>
              </li>
              <li class="nav-item">
                @if (session('isLogin'))
                <a class="nav-link text-danger" href="{{ route('logout') }}">Logout</a>
                @else
                <a class="nav-link" href="{{ route('login') }}">Login</a>
                @endif
              </li>
            </ul>
          </div>
        </div>
      </nav>
</header> 
