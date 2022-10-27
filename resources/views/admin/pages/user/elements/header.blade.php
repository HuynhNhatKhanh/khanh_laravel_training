@php
    $searchValue = isset($requestAll['search']) ? $requestAll['search'] : '';
    $email = isset($requestAll['email']) ? $requestAll['email'] : '';
    $filterRole = isset($requestAll['filter_role']) ? $requestAll['filter_role'] : '';
    $filterStatus = isset($requestAll['filter_status']) ? $requestAll['filter_status'] : '';

    $optionsStatus = [
        'default' => '- Trạng thái -',
        '0' => 'Tạm khoá',
        '1' => 'Đang hoạt động',
    ];

    $optionsRole = [
        'default' => '- Nhóm-',
        'admin' => 'Admin',
        'reviewer' => 'Reviewer',
        'editor' => 'Editor',
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
        <div class="card card-info card-outline" id="search-user">
            <div class="card-header">
                <h1 class="card-title">Danh sách người dùng</h1>
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
                            <input type="text" class="form-control form-control-sm" id="name-search"
                                name="nameSearch" value="" style="min-width: 300px">
                        </div>
                    </div>
                    <div class="mb-1 col-3">
                        <p>Email</p>
                        <div class="input-group">
                            <input type="email" class="form-control form-control-sm" name="email" id="email-search"
                                value="" style="min-width: 100px">
                        </div>
                    </div>
                    <div class="mb-1 col-2">
                        <p style="">Nhóm</p>
                        <select id="filter_role" name="filter_role" class="custom-select custom-select-sm mr-1"
                            style="min-width: 100px">
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
                            style="min-width: 100px">
                            @foreach ($optionsStatus as $key => $val)
                                <option value="{{ $key }}" @selected($key == $filterStatus)>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row justify-content-between p-2">
                    <div>
                        <button type="button" class="btn btn-sm btn-success" id="addNewUser" data-toggle="modal">Thêm mới</button>
                    </div>
                    <div class="mb-1 ">

                        <div class="input-group mr-auto">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-danger"
                                    id="btn-clear-search-user">Clear</button>
                                <button type="submit" class="btn btn-sm btn-info" id="btn-search-user">Search</button>
                            </div>
                        </div>

                    </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
