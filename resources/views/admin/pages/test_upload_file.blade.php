
{!! Form::open(['url' => '/upload', 'method' => 'post', 'files' => true]) !!}
     <!-- File upload chap nhap type Image -->
     {!! Form::file('product_image', ['accept' => 'image/*']) !!} <br>
     {!! Form::submit('Upload') !!}
{!! Form::close() !!}
