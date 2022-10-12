@php
    $searchValue = isset($requestAll['search']) ? $requestAll['search'] : '';
    $priceToValue = isset($requestAll['price_to']) ? $requestAll['price_to'] : '';
    $priceFromValue = isset($requestAll['price_from']) ? $requestAll['price_from'] : '';
    $filterStatus = isset($requestAll['filter_status']) ? $requestAll['filter_status'] : '';

    $optionsStatus = [
        'default' => '- Trạng thái -',
        '1' => 'Đang bán',
        '2' => 'Hết hàng',
        '3' => 'Ngừng bán'
    ];

@endphp

<section class="content-header">
    <div class="container-fluid">
        <!-- Search & Filter -->
        <div class="card card-info card-outline">
            <div class="card-header">
                <h6 class="card-title">Search & Filter</h6>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-between">
                    <form action="" method="get" class="input-group justify-content-between">
                    <div class="mb-1 col-4">
                        <p>Tên sản phẩm</p>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" name="search" value="{{ $searchValue }}"
                                style="min-width: 300px">
                        </div>
                    </div>
                    <div class="mb-1 col-2">
                        <p style="">Trạng thái</p>
                        <select id="filter_status" name="filter_status" class="custom-select custom-select-sm mr-1"
                            style="width: 150px">
                            @foreach ($optionsStatus as $key => $val)
                                <option value="{{ $key }}" @selected($key == $filterStatus)>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-1 col-3">
                        <p>Giá bán từ</p>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" name="price_from"
                                value="{{ $priceFromValue }}" style="min-width: 100px">
                        </div>
                    </div>
                    <div class="mb-1 col-3">
                        <p>Giá bán đến</p>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" name="price_to"
                                value="{{ $priceToValue }}" style="min-width: 100px">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div>
                        <button type="button" class="btn btn-sm btn-success" id="" data-toggle="modal" data-target="#FormProductModal">Thêm
                            mới</button>
                        {{-- @include('admin.pages.elements.form') --}}
                    </div>
                    <div class="mb-1 ">

                            <div class="input-group mr-auto">
                                <div class="input-group-append">
                                    <a href="{{ route('product') }}" type="button" class="btn btn-sm btn-danger"
                                        id="btn-clear-search">Clear</a>
                                    <button type="submit" class="btn btn-sm btn-info"
                                        id="btn-search">Search</button>
                                </div>
                            </div>

                    </div>
                </form>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách sản phẩm</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
