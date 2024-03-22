<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Client validation</title>
</head>
<body>
    <style>
        label[id*='-error'] {
            color: red;
        }
    </style>
    @include('components.navbar')
    <main class="m-5">
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
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <script>
        $(document).ready(function () {
            $("#myForm").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 5,
                        maxlength: 20
                    },
                    age: {
                        required: true,
                        number: true
                        
                    },
                    email: {
                        required: true,
                        email: true,
                        customEmail: true
                    },
                    date: {
                        required: true,
                        date: true
                    },
                    url: {
                        required: true,
                        url: true
                    },
                    hiragana: {
                        required: true,
                        customHiragana: true
                    },
                    katakana: {
                        required: true,
                        customKatakana: true
                    },
                    kanji: {
                        required: true,
                        customKanji: true
                    },
                },
                // messages: {
                    // name: {
                    //     required: "This field is",
                    //     minlength: "Vui lòng nhập ít nhất 5 ký tự.",
                    //     maxlength: "Vui lòng không nhập quá 20 ký tự."
                    // }
                // }
            });

            $.validator.addMethod("customEmail", function(value, element) {
                return this.optional(element) || /^([a-zA-Z0-9_.+-])+@gmail\.com$/.test(value);
            }, "Please type your gmail format");

            $.validator.addMethod("customHiragana", function (value, element) {
                return this.optional(element) || /^[ぁ-ん]+$/.test(value);
            }, "Please type Hiragana");
            $.validator.addMethod("customKatakana", function (value, element) {
                return this.optional(element) || /^[ァ-ン]+$/.test(value);
            }, "Please type Katakana");
            $.validator.addMethod("customKanji", function (value, element) {
                return this.optional(element) || /^[一-龥]+$/.test(value);
            }, "Please type Kanji");
        });
        
    </script>
</body>
</html>