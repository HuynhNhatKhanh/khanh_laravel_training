@php
    $searchValue = isset($requestAll['search']) ? $requestAll['search'] : '';
    $priceToValue = isset($requestAll['price_to']) ? $requestAll['price_to'] : '';
    $priceFromValue = isset($requestAll['price_from']) ? $requestAll['price_from'] : '';
    $filterStatus = isset($requestAll['filter_status']) ? $requestAll['filter_status'] : '';

    $optionsStatus = [
        'default' => '- Trạng thái -',
        '1' => 'Đang bán',
        // '1' => 'Hết hàng',
        '0' => 'Ngừng bán'
    ];

@endphp

<section class="content-header">

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="container-fluid">
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
                        <p>Tên sản phẩm</p>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" name="product-name-search" id="product-name-search" value=""
                                style="min-width: 300px">
                        </div>
                    </div>
                    <div class="mb-1 col-2">
                        <p style="">Trạng thái</p>
                        <select id="product-filte-status" name="product-filte-status" class="custom-select custom-select-sm mr-1"
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
                            <input type="number" class="form-control form-control-sm" name="price-from-search" id="price-from-search"
                                value="" style="min-width: 100px">
                        </div>
                    </div>
                    <div class="mb-1 col-3">
                        <p>Giá bán đến</p>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" name="price-to-search" id="price-to-search"
                                value="" style="min-width: 100px">
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
                                <button  type="button" class="btn btn-sm btn-danger"
                                    id="btn-clear-search-product">Clear</button>
                                <button type="submit" class="btn btn-sm btn-info"
                                    id="btn-search-product">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
