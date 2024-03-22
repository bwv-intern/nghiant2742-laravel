<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Client validation</title>
</head>
<body >
    <style>
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 120px;

        }

        .text-justify {
            text-align: justify;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .backdrop {
            position: fixed;
            top: 0;
            left: 0;
            background-color: gray;
            width: 100%;
            height: 100%;
            opacity: .5;
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .not-allowed {
            pointer-events: auto! important;
            cursor: not-allowed! important;
        }
    </style>
    @include('components.navbar')
    
    <main class="m-2 m-md-5">
        {{-- Requirement 1 --}}
        <div class="alert alert-primary">
            - Hiển thị toàn bộ data theo đúng max-length cũng không bị bể layout.
        </div>
        <p>
            <b>Cách 1:</b> Qui Lorem commodo ipsum irure quis qui labore voluptate eu fugiat nisi culpa ad. Laborum amet consequat proident exercitation consectetur reprehenderit occaecat adipisicing elit sunt ad. Sint est in dolor eiusmod do Lorem nisi excepteur quis irure esse laborum. Nisi dolore adipisicing labore officia duis. Ea est Lorem do incididunt. Duis laboris nisi est reprehenderit nostrud. Do veniam labore occaecat in do pariatur non id irure aliqua aute.
        </p>
        <p class="truncate" style="max-width: 80vw;">
            <b>Cách 2:</b> Consectetur proident cupidatat ex quis ipsum commodo magna consectetur elit. Pariatur tempor sit dolore eu magna eu veniam elit ipsum nisi. Aliquip minim dolor exercitation voluptate labore dolor.
        </p>
    
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Second</th>
                <th scope="col">Third</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row" style="white-space: nowrap;">Cách 1</th>
                <td class="text-justify">Qui Lorem commodo ipsum irure quis qui labore voluptate eu fugiat nisi culpa ad. Laborum amet consequat proident exercitation consectetur reprehenderit occaecat adipisicing elit sunt ad. Sint est in dolor eiusmod do Lorem nisi excepteur quis irure esse laborum. Nisi dolore adipisicing labore officia duis. Ea est Lorem do incididunt. Duis laboris nisi est reprehenderit nostrud. Do veniam labore occaecat in do pariatur non id irure aliqua aute.</td>
                <td class="text-justify">Qui Lorem commodo ipsum irure quis qui labore voluptate eu fugiat nisi culpa ad. Laborum amet consequat proident exercitation consectetur reprehenderit occaecat adipisicing elit sunt ad. Sint est in dolor eiusmod do Lorem nisi excepteur quis irure esse laborum. Nisi dolore adipisicing labore officia duis. Ea est Lorem do incididunt. Duis laboris nisi est reprehenderit nostrud. Do veniam labore occaecat in do pariatur non id irure aliqua aute.</td>
                <td class="text-justify">Qui Lorem commodo ipsum irure quis qui labore voluptate eu fugiat nisi culpa ad. Laborum amet consequat proident exercitation consectetur reprehenderit occaecat adipisicing elit sunt ad. Sint est in dolor eiusmod do Lorem nisi excepteur quis irure esse laborum. Nisi dolore adipisicing labore officia duis. Ea est Lorem do incididunt. Duis laboris nisi est reprehenderit nostrud. Do veniam labore occaecat in do pariatur non id irure aliqua aute.</td>
              </tr>
              <tr>
                <th scope="row" style="white-space: nowrap;">Cách 2</th>
                <td class="truncate">Consectetur proident cupidatat ex quis ipsum commodo magna consectetur elit. Pariatur tempor sit dolore eu magna eu veniam elit ipsum nisi. Aliquip minim dolor exercitation voluptate labore dolor.</td>
                <td class="truncate">Consectetur proident cupidatat ex quis ipsum commodo magna consectetur elit. Pariatur tempor sit dolore eu magna eu veniam elit ipsum nisi. Aliquip minim dolor exercitation voluptate labore dolor.</td>
                <td class="truncate">Consectetur proident cupidatat ex quis ipsum commodo magna consectetur elit. Pariatur tempor sit dolore eu magna eu veniam elit ipsum nisi. Aliquip minim dolor exercitation voluptate labore dolor.</td>
              </tr>
            </tbody>
          </table>
    
        {{-- Requirement 2 --}}
        <div class="alert alert-primary mt-3">
            - Data có chứa mã xuống dòng thì khi hiển thị lên màn hình phải có xuống dòng.
        </div>
        <h3>{!! $lines !!}</h3>
    
        {{-- Requirement 3 --}}
        <div class="alert alert-primary mt-3">
            - Xác nhận cử động khi nhấn back trên browser.
        </div>
        <form action="/confirmSubmit" method="POST">
            @csrf
            <label for="fullname">Fullname:</label>
            <input type="text" name="fullname"  required>
            <label for="age">Age:</label>
            <input type="number" name="age" required>
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
    
        {{-- Requirement 4 --}}
        <div class="alert alert-primary mt-3">
            - Xử lý submit hiển thị loading animation.
        </div>
        <form action="/confirmSubmit" method="POST">
            @csrf
            <button class="btn btn-primary" type="submit" id="btnAnimationSubmit">
                Submit
            </button>
        </form>
        
        <div class="backdrop">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
        </div>
    
        {{-- Requirement 5 --}}
        <div class="alert alert-primary mt-3">
            - Xử lý thao tác nhấn button submit chỉ được thao tác 1 lần.
        </div>
        <form action="/confirmSubmit" method="POST">
            @csrf
            <button class="btn btn-primary" type="submit" id="btnOnceSubmit">
                Submit
            </button>
        </form>
        
        <div class="backdrop">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
        </div>

        {{-- Requirement 6 --}}
        <div class="alert alert-primary mt-3">
            - Xử lý enter phải được thực hiện.
        </div>
        <form action="/confirmSubmit" method="POST">
            @csrf
            <label for="fullname">Search:</label>
            <input type="text" name="search"  required>
            <button class="btn btn-primary" type="submit" id="btnEnterSubmit">
                Submit
            </button>
        </form>



    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script>
        $(document).ready(function () {
            // Req 4
            $('#btnAnimationSubmit').click(function (e) { 
                e.preventDefault();
                $('.backdrop').css('display', 'flex');

                setTimeout(() => {
                    $('.backdrop').css('display', 'none');
                }, 5000);
            });

            // Req 5
            $('#btnOnceSubmit').click(function (e) { 
                e.preventDefault();
                $('#btnOnceSubmit').attr('disabled', true);
                $('#btnOnceSubmit').addClass('not-allowed');
            });

        });
        
    </script>
</body>
</html>