@extends('layouts.admin')

@section('main')


{{-- <div class="d-flex justify-content-center">
    {!! $items->links() !!}
</div> --}}
<!-- List Content -->
<form action="" method="post" class="table-responsive" id="form-table">
    <table class="table table-bordered table-hover text-nowrap btn-table mb-0">
        <thead>
            <tr>
                {{-- <th class="text-center">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="check-all">
                        <label for="check-all" class="custom-control-label"></label>
                    </div>
                </th> --}}
                <th class="text-center">#</th>
                <th class="">Tên sản phẩm</th>
                <th class="">Mô tả</th>
                <th class="text-center">Giá</th>
                <th class="text-center">Tình trạng</th>
                <th class="text-center">Hành động</th>
                {{-- <th class="text-center">Status</th>
                <th class="text-center">Special</th>
                <th class="text-center">Ordering</th>
                <th class="text-center">Created</th>
                <th class="text-center">Action</th> --}}
            </tr>
        </thead>
        <tbody>
            @php
                $page = 0;
                if(isset($requestAll['page']) && $requestAll['page'] > 0){
                    $page = ( $requestAll['page'] - 1 ) * 10;
                }
            @endphp
            @foreach ($items as $key => $item)
                <tr>
                    <td class="text-center">{{ $page  + $key + 1}}</td>
                    <td class="text-wrap" style="min-width: 60px">{{ $item['product_name'] }}</td>
                    <td class="text-wrap" style="min-width: 60px">{{ $item['description'] }}</td>
                    <td class="text-center">$ {{ $item['product_price'] }}</td>
                    <td class="text-center">{{ ($item['is_sales'] == 0) ? 'Ngừng bán' : 'Còn hàng' }}</td>
                    <td class="text-center">
                        <a href="#" class="rounded-circle btn btn-sm btn-info" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="" class="rounded-circle btn btn-sm btn-danger" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            {{-- <tr>
                <td class="text-center">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="checkbox-5" name="checkbox[]" value="5">
                        <label for="checkbox-5" class="custom-control-label"></label>
                    </div>
                </td>
                <td class="text-center">5</td>
                <td class="text-wrap" style="min-width: 180px">Nuôi Con Không Phải Là Cuộc Chiến (Tái Bản 2020)</td>
                <td style="width: 100px; padding: 5px"><a data-toggle="modal" data-target="#modal-image"><img class="item-image w-100" src="images/category2.jpg"></a></td>
                <td class="text-center">99,000 đ</td>
                <td class="text-center">37%</td>
                <td class="text-center position-relative">
                    <select name="select-category" class="custom-select custom-select-sm" style="width: unset" id="5" data-id="5">
                        <option value="1">Bà mẹ - Em bé</option>
                        <option value="2" selected>Chính Trị - Pháp Lý</option>
                        <option value="3">Công Nghệ Thông Tin</option>
                        <option value="4">Giáo Khoa - Giáo Trình</option>
                        <option value="5">Học Ngoại Ngữ</option>
                    </select>
                </td>
                <td class="text-center position-relative">
                    <a href="#" class="my-btn-state rounded-circle btn btn-sm btn-success"><i class="fas fa-check"></i></a>
                </td>
                <td class="text-center position-relative">
                    <a href="#" class="my-btn-state rounded-circle btn btn-sm btn-success"><i class="fas fa-check"></i></a>
                </td>
                <td class="text-center position-relative"><input type="number" name="chkOrdering[5]" value="1" class="chkOrdering form-control form-control-sm m-auto text-center" style="width: 65px" id="chkOrdering[5]" data-id="5" min="1"></td>
                <td class="text-center">
                    <p class="mb-0 history-by"><i class="far fa-user"></i> admin</p>
                    <p class="mb-0 history-time"><i class="far fa-clock"></i> 15/07/2020 10:39:24</p>
                </td>
                <td class="text-center">
                    <a href="#" class="rounded-circle btn btn-sm btn-info" title="Edit">
                        <i class="fas fa-pencil-alt"></i>
                    </a>

                    <a href="#" class="rounded-circle btn btn-sm btn-danger" title="Delete">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr> --}}
        </tbody>
    </table>
</form>

@endsection
