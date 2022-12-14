@php
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
    <div class="container">
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
            <div class="card-body" id="search-user">
                <div class="row justify-content-between">
                    {{-- <form action="" method="get" class="input-group justify-content-between"> --}}
                    <div class="mb-1 col-3">
                        <label for="name-search" class="font-weight-normal">Tên người dùng</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" id="name-search" placeholder="Nhập họ tên"
                                name="nameSearch" value="" style="min-width: 300px">
                        </div>
                    </div>
                    <div class="mb-1 col-3">
                        <label for="email-search" class="font-weight-normal">Email </label>
                        <div class="input-group">
                            <input type="email" class="form-control form-control-sm" name="email" placeholder="Nhập email" id="email-search"
                                value="" style="min-width: 100px">
                        </div>
                    </div>
                    <div class="mb-1 col-2">
                        <label for="filter_role" class="font-weight-normal">Nhóm </label>
                        <select id="filter_role" name="filter_role" class="custom-select-sm mr-1 form-control"
                            style="min-width: 100px">
                            @foreach ($optionsRole as $key => $val)
                                <option value="{{ $key }}">
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-1 col-2">
                        <label for="filter_status" class="font-weight-normal">Trạng thái </label>
                        <select id="filter_status" name="filter_status" class="custom-select-sm mr-1 form-control"
                            style="min-width: 100px">
                            @foreach ($optionsStatus as $key => $val)
                                <option value="{{ $key }}" >
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row justify-content-between p-2">
                    <div>
                        <button type="button" class="btn btn-sm btn-success" id="addNewUser" data-toggle="modal"><i class="fas fa-plus"></i>&nbsp; Thêm mới</button>
                    </div>
                    <div class="mb-1 ">
                        <div class="input-group mr-auto">
                            <div class="input-group-append">
                                <button type="button"  style="margin-right: 28px; border-radius: 3px"  class="btn btn-sm btn-danger"
                                    id="btn-clear-search-user"><i class="fas fa-times"></i>&nbsp; Xoá tìm</button>
                                <button type="submit" class="btn btn-sm btn-info" style="border-radius: 3px" id="btn-search-user"><i class="fas fa-search"></i>&nbsp; Tìm kiếm</button>
                            </div>
                        </div>

                    </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
