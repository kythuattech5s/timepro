<table class="table">
    <thead>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Giảm giá</th>
            <th>Kích hoạt</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @forelse($listItems as $key => $item)
            @php
                $checked = true;
                $itemContain = isset($listItemOld) ? $listItemOld->first(fn($q) => (int) $q['id'] === $item->id) : null;
                if ($itemContain !== null) {
                    $checked = $itemContain['act'] == 1 ? true : false;
                }
            @endphp
            <tr data-id="{-item.id-}">
                <td data-label="Sản phẩm" class="align-items-center flex justify-start space-x-2 text-left">
                    <img class="h-10 w-10" src="{%IMGV2.item.img.-1%}" alt="{%AIMGV2.item.img.alt%}"
                         title="{%AIMGV2.item.img.title%}">
                    <a href="{-item.slug-}" target="_blank">
                        {-item.name-}
                    </a>
                </td>
                @php
                    $listPrice = FlashSaleHelper::getPriceOfItem($item);
                @endphp
                <td data-label="Giá">
                    @if ($listPrice['max'] > 0 && $listPrice['min'] < $listPrice['max'])
                        {{ $listPrice['min'] }} ~ {{ $listPrice['max'] }}
                    @else
                        {{ $listPrice['min'] }}
                    @endif
                </td>
                <td>
                    <input type="text" class="rounded-sm border px-2" name="discount" value="{{ $itemContain !== null ? $itemContain['discount'] : '' }}" placeholder="Phần trăm giảm giá">
                </td>
                <td>
                    <label class="switch">
                        <input type="checkbox" name="act" value="{{ $checked ? 1 : 0 }}" onclick="this.value = this.checked ? 1 : 0" {{ $checked ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </td>
                <td data-label="Thao tác">
                    <div class="action">
                        <button type="button" class="btn btn-sm bg-red-400 text-white" title="Xóa"><i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%">Không có kết quả phù hợp.</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $listItems->withQueryString()->links('vh::base.pagination', ['attributeAjax' => 'pagination-flashsale-list', 'attribute' => 'data-promotion=flashsale data-page']) }}
