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
                    $page = ($requestAll['page'] - 1) * ($items->perPage());
                }
            @endphp
            @foreach ($items as $key => $item)
                <tr>
                    <td class="text-center">{{ $page + $key + 1 }}</td>
                    <td class="text-wrap img_hover" style="min-width: 60px">
                        {{ $item['product_name'] }}
                        <div class="">
                            <img src="{{url('storage/backend')}}/images/product/{{$item['product_image']}}" alt="">
                        </div>
                    </td>
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
                        <button type="button" value="{{$item['product_id']}}" class="rounded-circle btn btn-sm btn-info editbtn"
                            title="Chỉnh sửa">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <a href="product/delete/{{$item['product_id']}}" class="rounded-circle btn btn-sm btn-danger btn-delete" title="Xoá">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</form>
