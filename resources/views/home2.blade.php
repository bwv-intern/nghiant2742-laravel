<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Server validation</title>
</head>
<body>
    <style>
        label[id*='-error'] {
            color: red;
        }
    </style>
    @include('components.navbar')

    <div class="m-5 row" >
        <div class="col-6">
            <form action="/handle" id="myForm" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="text" class="form-control"  name="age" id="age">
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Date</label>
                    <input type="date" class="form-control"  name="date" id="date">
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Email</label>
                    <input type="email" class="form-control"  name="email" id="email">
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Portfolio (URL)</label>
                    <input type="text" class="form-control"  name="url" id="url">
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Hiragana</label>
                    <input type="text" class="form-control"  name="hiragana" id="hiragana">
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Katakana</label>
                    <input type="text" class="form-control"  name="katakana" id="katakana">
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Kanji</label>
                    <input type="text" class="form-control"  name="kanji" id="kanji">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    
        <div class="col-5">
            @if ($errors->any())
                <h2 class="text-danger">Something was wrong!!!</h2>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
                
            @endif
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>