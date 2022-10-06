<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Document</title>
</head>

<body>
    <div class="container" >
        {!! Form::open(['url' => 'user/login', 'method' => 'POST']) !!}

            <div class="form-group p-1">
                <p>Giá: <span id="price">15000</span></p>
                {!! Form::label('number_order', 'Số lượng') !!}

                <input type="number" id="number" name="number" value="0">
                <p>Tổng: <span id="total">0</span></p>
            </div>

        {!! Form::close() !!}
    </div>
    <!-- jQuery -->
    <script src="{{url('backend')}}/plugins/jquery/jquery.min.js"></script>
    <script src="{{ asset('backend/js/testformajax.js') }}"></script>
</body>
</html>
