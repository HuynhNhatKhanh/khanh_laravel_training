@extends('layouts.app')

@section('title', 'Tiêu đề trang Child')

@include('layouts.cmt', ['titleCmt' => 'Comment bài viết'])
@section('content')
    <H2>Content Child</H2>
    <p>Họ và tên: {{$name}}</p>
    <p>Tuổi: {{$old}}</p>
    <p>Thông tin: {!! $data !!}</p>

    @if ($id %2 == 0)
        <p>{{$id}} là số chẵn</p>
    @else
        <p>{{$id}} là số lẻ</p>
    @endif

   @php
       foreach($users as $user){
           echo "<p>Tên: {$user['name']}</p>";
       }
   @endphp
@endsection

@section('sidebar')
    @parent
    <H2>Sidebar Child</H2>
@endsection
