@if ($listItems->count() > 0)
    <div class="header d-flex justify-content-between mb-3">
        <p>Đã chọn <span class="count-product-chooses">{{ $listItems->total() }}</span> sản phẩm</p>
        @if (!isset($lock) || !$lock)
            <button type="button" class="btn bg-green-400 text-white" data-toggle="modal" data-target="#modalProduct" data-type="vouchers">
                Thêm sản phẩm
            </button>
        @endif
    </div>
    <div class="list-product">
        @include('tpv::components.table_item')
    </div>
@else
    <button type="button" class="btn bg-green-400 text-white" data-toggle="modal" data-target="#modalProduct" data-type="vouchers">
        Thêm sản phẩm
    </button>
@endif
