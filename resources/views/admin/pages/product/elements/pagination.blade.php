
@php
    $perPage = $items->perPage();
    $currentPage = $items->currentPage();
    $count = $items->count();

@endphp

<div class=" d-flex row align-items-center ">
    <div class="col-4">

    </div>
    <div class="col-4" style="margin-bottom: -15px;">
        <div >
            @foreach ($items as $item)
                {{ $item->name }}
            @endforeach
        </div>
        {{ $items->appends(request()->query())->links() }}
    </div>
    <div class=" col-4 " style="text-align:end">
        <small >Hiển thị từ {{ $perPage * ($currentPage - 1) + 1 }} ~ {{ $perPage * ($currentPage - 1) + $count}} trong tổng <strong >{{  $items->total() }}</strong> sản phẩm</small>
    </div>
</div>

