@extends('layouts.admin')

@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        @include('admin.pages.user.elements.header')

        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->
                        <div class="card">
                            <div class="card-header">
                                @include('admin.pages.user.elements.pagination')
                            </div>
                            <div class="card-body">
                                <!-- List Content -->
                                @include('admin.pages.user.elements.list_content')
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                @include('admin.pages.user.elements.pagination')
                            </div>
                            <!-- /.card-footer-->
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
