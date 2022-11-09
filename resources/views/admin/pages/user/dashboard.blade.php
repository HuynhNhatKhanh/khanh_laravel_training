@extends('layouts.admin')

@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        @include('admin.pages.user.elements.header')

        <!-- Main content -->
        <section class="content">

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->
                        <div class="card">
                            <div class="card-body py-0">
                                <!-- List Content -->
                                @include('admin.pages.user.elements.list_content')
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
