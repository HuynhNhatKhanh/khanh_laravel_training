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
                    <div class="mb-1 col-3">
                        <label for="customer-name-search" class="font-weight-normal">Tên khách hàng</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" id="customer-name-search" placeholder="Nhập họ tên"
                                name="customer-name-search" value="" style="min-width: 300px">
                        </div>
                    </div>
                    <div class="mb-1 col-3">
                        <label for="customer-email-search" class="font-weight-normal">Email </label>
                        <div class="input-group">
                            <input type="email" class="form-control form-control-sm" name="customer-email-search" id="customer-email-search" placeholder="Nhập email"
                                value="" style="min-width: 100px">
                        </div>
                    </div>
                    <div class="mb-1 col-2">
                        <label for="customer-address-search" class="font-weight-normal">Địa chỉ </label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm" id="customer-address-search" placeholder="Nhập địa chỉ"
                            name="customer-address-search" value="" style="min-width: 200px">
                        </div>
                    </div>
                    <div class="mb-1 col-2">
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
                <div class="row justify-content-between p-2" style="height: 50px">
                    <div class="col-2 pl-0">
                        <button type="button" class="btn btn-sm btn-success" id="addNewCustomer" data-toggle="modal"><i class="fas fa-plus"></i>&nbsp; Thêm mới</button>
                    </div>
                    <div class="mb-3 row input-group-append col-7" style="height:50px; margin-left: -142px;">
                        {{-- <form id="uploadFileCSV" enctype="multipart/form-data">
                            <label for="importCSV" class="btn btn-sm btn-info " style="margin-right: 20px ;height:30px"> <i class="fa fa-upload"></i> &nbsp;Import
                              CSV
                              <input class="hidden" name="customersFile" id="importCSV" type="file" >
                            </label>
                          </form> --}}
                          <button type="button" style="margin-right: 25px ;height:30px" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal" id="buttonImport"><i class="fa fa-upload"></i> &nbsp;
                            Nhập dữ liệu
                            </button>

                          <button type="button" id="exportCSV" class="btn btn-sm btn-success" style="height:30px"><i class="fa fa-download" ></i> &nbsp;Xuất dữ liệu</button>
                    </div>

                    <div class="mb-1 col-3 pr-0">
                        <div class="input-group mr-auto justify-content-end ml-0">
                            <div class="input-group-append">
                                <button type="button" style="margin-right: 28px; border-radius: 3px;" class="btn btn-sm btn-danger"
                                    id="btn-clear-search-customer"><i class="fas fa-times"></i>&nbsp; Xoá tìm</button>
                                <button type="submit" class="btn btn-sm btn-info"  style="border-radius: 3px" id="btn-search-customer"><i class="fas fa-search"></i>&nbsp; Tìm kiếm</button>
                            </div>
                        </div>
                    </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
