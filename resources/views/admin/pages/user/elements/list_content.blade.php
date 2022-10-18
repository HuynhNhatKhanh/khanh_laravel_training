<form action="" method="post" class="table-responsive" id="form-table">
    <table class="table table-bordered table-hover text-nowrap btn-table mb-0">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="">Họ Tên</th>
                <th class="">Email</th>
                <th class="text-center">Nhóm</th>
                <th class="text-center">Trạng thái</th>
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
                    <td class="text-wrap img_hover" style="min-width: 60px">{{ $item['name'] }}</td>
                    <td class="text-wrap" style="min-width: 60px">{{ $item['email'] }}
                    </td>
                    <td class="text-center"><span class="">{{ Str::ucfirst( $item['group_role'])  }}</span></td>
                    <td class="text-center">

                    @if ($item['is_active'] == 0)
                        <span class="text-danger">Tạm khoá</span>
                    @elseif ($item['is_active'] == 1)
                        <span class="text-success">Đang hoạt động</span>
                    @endif

                    <td class="text-center">
                        <button type="button" value="{{$item['id']}}" class="rounded-circle btn btn-sm btn-info editbtn"
                            title="Chỉnh sửa">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <a href="product/delete/{{$item['id']}}" class="rounded-circle btn btn-sm btn-danger btn-delete"
                            title="Xoá">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        <a href="" class="rounded-circle btn btn-sm btn-dark"
                            title="Khoá thành viên">
                            <i class="fas fa-user-times"></i>
                        </a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</form>
