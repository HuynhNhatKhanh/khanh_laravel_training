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
    <div class="container">
        <h1>Form</h1>
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        @endif
        {!! Form::open(['url' => 'news/push', 'method' => 'GET']) !!}
        <div class="form-group">
            {!! Form::text('title', '', [
                'class' => 'form-control',
                'placeholder' => ' Tiêu đề',
            ]) !!}
            @error('title')
                <small class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            {!! Form::textarea('content', '', [
                'class' => 'form-control',
                'placeholder' => ' Text',
            ]) !!}
            @error('content')
                <small class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            {!! Form::submit('Thêm mới', [
                'class' => 'btn btn-success',
            ]) !!}
        </div>
        {!! Form::close() !!}
    </div>
</body>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

</html>
