@php
    $optionsStatus = [
        'default' => '- Trạng thái -',
        '1' => 'Đang bán',
        '0' => 'Ngừng bán'
    ];

@endphp

<section class="content-header">
    <div class="container">
        <!-- Search & Filter -->
        <div class="card card-info card-outline">
            <div class="card-header">
                <h1 class="card-title">Danh sách sản phẩm</h1>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body" id="search-product">
                <div class="row justify-content-between">
                    <form action="" method="get" class="input-group justify-content-between">
                    <div class="mb-1 col-4">
                        <label for="product-name-search" class="font-weight-normal">Tên sản phẩm</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" name="product-name-search" placeholder="Nhập tên sản phẩm" id="product-name-search" value=""
                                style="min-width: 300px">
                        </div>
                    </div>
                    <div class="mb-1 col-2">
                        <label for="product-filte-status" class="font-weight-normal">Trạng thái</label>
                        <select id="product-filte-status" name="product-filte-status" class="custom-select-sm mr-1 form-control"
                            style="width: 150px">
                            @foreach ($optionsStatus as $key => $val)
                                <option value="{{ $key }}" >
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-1 col-3">
                        <label for="price-from-search" class="font-weight-normal">Giá bán từ</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" name="price-from-search" id="price-from-search" placeholder="Nhập giá từ"
                                value="" style="min-width: 100px">
                        </div>
                    </div>
                    <div class="mb-1 col-3">
                        <label for="price-to-search" class="font-weight-normal">Giá bán đến</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" name="price-to-search" id="price-to-search"
                            placeholder="Nhập giá đến"
                                value="" style="min-width: 100px">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between p-2">
                    <div>
                        {{-- <button type="button" class="btn btn-sm btn-success" id="" data-toggle="modal" data-target="#FormProductModal">Thêm
                            mới</button> --}}
                        <button type="button" class="btn btn-sm btn-success" id="addNewProduct" data-toggle="modal"><i class="fas fa-plus"></i>&nbsp; Thêm mới</button>
                        {{-- @include('admin.pages.elements.form') --}}
                    </div>
                    <div class="mb-1 ">
                        <div class="input-group mr-auto">
                            <div class="input-group-append">
                                <button  type="button" style="margin-right: 28px; border-radius: 3px;" class="btn btn-sm btn-danger"
                                    id="btn-clear-search-product"><i class="fas fa-times"></i>&nbsp; Xoá tìm</button>
                                <button type="submit" class="btn btn-sm btn-info" style="border-radius: 3px"
                                    id="btn-search-product"><i class="fas fa-search"></i>&nbsp; Tìm kiếm</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
