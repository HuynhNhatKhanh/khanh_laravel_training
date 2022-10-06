<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Form test</title>
</head>

<body>
    <div class="container" >
        <h1>Form Validate</h1>
        {{-- @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        @endif --}}
        {!! Form::open(['url' => 'user/login', 'method' => 'POST']) !!}

        <div class="form-group p-1">
            {!! Form::label('username', 'Username') !!}
            {!! Form::text('username', '', [
                'class' => 'form-control',
                'id'=> 'username',
                'placeholder' => 'Tên tài khoản',
            ]) !!}
            @error('username')
                <small class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group p-1">
            {!! Form::label('password', 'Password') !!}
            {!! Form::password('password', [
                'class' => 'form-control',
                'id'=> 'password',
                'placeholder' => 'Mật khẩu',
            ]) !!}
            @error('password')
                <small class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- <div class="form-group">
            {!! Form::textarea('content', '', [
                'class' => 'form-control',
                'placeholder' => ' Text',
            ]) !!}
            @error('content')
                <small class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div> --}}

        <div class="form-group p-1">
            {!! Form::submit('Đăng nhập', [
                'class' => 'btn btn-success',
                'id' => 'submid-form-login'
            ]) !!}
        </div>

        {!! Form::close() !!}
    </div>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script>

    </script>
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
