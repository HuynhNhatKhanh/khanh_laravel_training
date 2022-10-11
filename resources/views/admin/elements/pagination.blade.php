<div class="d-flex justify-content-center">
    <div class="">
        @foreach ($items as $item)
            {{ $item->name }}
        @endforeach
    </div>
    {{ $items->links() }}
</div>
