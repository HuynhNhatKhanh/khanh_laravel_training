@php
    $optionsStatus = [
        'default' => '- Trạng thái -',
        '0' => 'Tạm khoá',
        '1' => 'Đang hoạt động',
    ];
@endphp

<section class="content-header">

    <div class="container">
        <!-- Search & Filter -->
        <div class="card card-info card-outline" id="search-user">
            <div class="card-header">
                <h1 class="card-title">Danh sách khách hàng</h1>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body pb-0" id="search-customer" >
                <div class="row justify-content-between">
                    <div class="mb-1 col-md-6 col-sm-12 col-lg-3">
                        <label for="customer-name-search" class="font-weight-normal">Tên khách hàng</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" id="customer-name-search" placeholder="Nhập họ tên"
                                name="customer-name-search" >
                        </div>
                    </div>
                    <div class="mb-1 col-md-6 col-sm-12 col-lg-3">
                        <label for="customer-email-search" class="font-weight-normal">Email </label>
                        <div class="input-group">
                            <input type="email" class="form-control form-control-sm" name="customer-email-search" id="customer-email-search" placeholder="Nhập email"
                                value="" style="min-width: 100px">
                        </div>
                    </div>
                    <div class="mb-1 col-md-6 col-sm-12 col-lg-3">
                        <label for="customer-address-search" class="font-weight-normal">Địa chỉ </label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" id="customer-address-search" placeholder="Nhập địa chỉ"
                            name="customer-address-search" value="" style="min-width: 200px">
                        </div>
                    </div>
                    <div class="mb-1 col-md-6 col-sm-12 col-lg-3">
                        <label for="customer-filte-status" class="font-weight-normal">Trạng thái </label>
                        <select id="customer-filte-status" name="customer-filte-status" class="custom-select-sm mr-1 form-control"
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
                    <div class="col-lg-9 col-md-12 order-2 order-lg-1 pl-0">

                        <button type="button" class="btn btn-sm btn-success btn--nowrap" id="addNewCustomer" data-toggle="modal"><i class="fas fa-plus "></i>&nbsp; Thêm mới</button>

                        <button type="button" style="height:30px" class="btn btn-sm btn-info ml-25" data-bs-toggle="modal" data-bs-target="#exampleModal" id="buttonImport"><i class="fa fa-upload"></i> &nbsp;
                            Nhập dữ liệu
                            </button>

                          <button type="button" id="exportCSV" class="btn btn-sm btn-success ml-25" style="height:30px"><i class="fa fa-download" ></i> &nbsp;Xuất dữ liệu</button>

                    </div>

                    <div class="mb-1 col-lg-3 col-md-12 pl-0 order-1 order-lg-2 mb-2 pr-lg-0 d-flex  justify-content-lg-end">
                        <button type="button" style="margin-right: 28px; border-radius: 3px;" class="btn btn-sm btn-danger btn--nowrap" id="btn-clear-search-customer"><i class="fas fa-times"></i>&nbsp; Xoá tìm</button>
                        <button type="submit" class="btn btn-sm btn-info btn--nowrap"  style="border-radius: 3px" id="btn-search-customer"><i class="fas fa-search"></i>&nbsp; Tìm kiếm</button>
                    </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
