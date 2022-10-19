@php
    $searchValue = isset($requestAll['search']) ? $requestAll['search'] : '';
    $email = isset($requestAll['email']) ? $requestAll['email'] : '';
    $filterRole = isset($requestAll['filter_role']) ? $requestAll['filter_role'] : '';
    $filterStatus = isset($requestAll['filter_status']) ? $requestAll['filter_status'] : '';

    $optionsStatus = [
        'default' => '- Trạng thái -',
        '0' => 'Tạm khoá',
        '1' => 'Đang hoạt động'
    ];

    $optionsRole= [
        'default' => '- Nhóm-',
        'admin' => 'Admin',
        'reviewer' => 'Reviewer',
        'editor' => 'Editor'
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
                <h6 class="card-title">Search & Filter</h6>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-between">
                    {{-- <form action="" method="get" class="input-group justify-content-between"> --}}
                    <div class="mb-1 col-3">
                        <p>Tên </p>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" id="name-search" name="nameSearch" value=""
                                style="min-width: 300px">
                        </div>
                    </div>
                    <div class="mb-1 col-3">
                        <p>Email</p>
                        <div class="input-group">
                            <input type="email" class="form-control form-control-sm" name="email"
                            id="email-search" value="" style="min-width: 100px">
                        </div>
                    </div>
                    <div class="mb-1 col-2">
                        <p style="">Nhóm</p>
                        <select id="filter_role" name="filter_role" class="custom-select custom-select-sm mr-1"
                            style="width: 170px">
                            @foreach ($optionsRole as $key => $val)
                                <option value="{{ $key }}" @selected($key == $filterRole)>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-1 col-2">
                        <p style="">Trạng thái</p>
                        <select id="filter_status" name="filter_status" class="custom-select custom-select-sm mr-1"
                            style="width: 170px">
                            @foreach ($optionsStatus as $key => $val)
                                <option value="{{ $key }}" @selected($key == $filterStatus)>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div>
                        <button type="button" class="btn btn-sm btn-success" id="" data-toggle="modal" data-target="#FormProductModal">Thêm mới</button>
                    </div>
                    <div class="mb-1 ">

                            <div class="input-group mr-auto">
                                <div class="input-group-append">
                                    <a href="{{ route('user') }}" type="button" class="btn btn-sm btn-danger"
                                        id="btn-clear-search">Clear</a>
                                    <button type="submit" class="btn btn-sm btn-info"
                                        id="btn-search">Search</button>
                                </div>
                            </div>

                    </div>
                {{-- </form> --}}
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Users</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
