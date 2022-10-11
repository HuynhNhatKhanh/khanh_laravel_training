@extends('layouts.admin')

@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        @include('admin.pages.elements.header')

        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->
                        <div class="card">
                            <div class="card-header">
                                @include('admin.elements.pagination')
                            </div>
                            <div class="card-body">
                                <!-- List Content -->
                                <form action="" method="post" class="table-responsive" id="form-table">
                                    <table class="table table-bordered table-hover text-nowrap btn-table mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="">Tên sản phẩm</th>
                                                <th class="">Mô tả</th>
                                                <th class="text-center">Giá</th>
                                                <th class="text-center">Tình trạng</th>
                                                <th class="text-center">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $page = 0;
                                                if (isset($requestAll['page']) && $requestAll['page'] > 0) {
                                                    $page = ($requestAll['page'] - 1) * 10;
                                                }
                                            @endphp
                                            @foreach ($items as $key => $item)
                                                <tr>
                                                    <td class="text-center">{{ $page + $key + 1 }}</td>
                                                    <td class="text-wrap" style="min-width: 60px">
                                                        {{ $item['product_name'] }}</td>
                                                    <td class="text-wrap" style="min-width: 60px">{{ $item['description'] }}
                                                    </td>
                                                    <td class="text-center"><span class="text-success">${{ $item['product_price'] }}</span></td>
                                                    <td class="text-center">
                                                        @php
                                                            $xhtml = '';
                                                            if ($item['is_sales'] == 0)
                                                            {
                                                                $xhtml = '<span class="text-danger">Ngừng bán</span>';
                                                            } else if( $item['is_sales'] == 1)
                                                            {
                                                                if ($item['ordering'] > 0)
                                                                {
                                                                    $xhtml = '<span class="text-success">Đang bán</span>';
                                                                } else if($item['ordering'] == 0){
                                                                    $xhtml = '<span class="text-success">Hết hàng</span>';
                                                                }
                                                            }
                                                        @endphp
                                                        {!! $xhtml !!}

                                                    <td class="text-center">
                                                        <a href="#" class="rounded-circle btn btn-sm btn-info"
                                                            title="Edit">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a href="product/delete/{{ $item['product_id'] }}" class="rounded-circle btn btn-sm btn-danger"
                                                            title="Delete">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                @include('admin.elements.pagination')
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
