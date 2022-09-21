@if ($listItems->count() > 0)
    <div class="header d-flex justify-content-between mb-3">
        <p>Đã chọn <span class="count-product-chooses">{{ $listItems->total() }}</span> sản phẩm</p>
        @if (!isset($lock) || !$lock)
            <button type="button" class="btn bg-green-400 text-white" data-toggle="modal" data-target="#modalProduct" data-type="flashsale">
                Thêm sản phẩm
            </button>
        @endif
    </div>
    <p class="text-2xl font-bold">Chỉnh sửa hàng loạt</p>
    <div class="my-3 flex gap-3">
        <div class="flex flex-1 items-center gap-4">
            <div class="flex items-center gap-3">
                <label for="">Phần trăm</label>
                <input type="text" class="rounded-sm border" name="discount_all" placeholder="% giảm cho tất cả">
            </div>
            <div class="flex items-center gap-3">
                <label for="">Kích hoạt</label>
                <select name="act_all" id="" class="rounded-sm border">
                    <option value="1">Kích hoạt</option>
                    <option value="0">Tắt kích hạot</option>
                </select>
            </div>
        </div>
        <button class="update-for-all bg-green-400 px-4 py-2">Cập nhật tất cả</button>
    </div>
    <div class="list-product">
        @include('tpf::components.table_item')
    </div>
@else
    <button type="button" class="btn bg-green-400 text-white" data-toggle="modal" data-target="#modalProduct" data-type="flashsale">
        Thêm sản phẩm
    </button>
@endif
