<tbody>
    @forelse($listItem as $item)
        @php
            $checked = false;
            if (isset($listChecked)) {
                $checked = $listChecked->contains(function ($product) use ($item) {
                    return isset($product->id) && (int) $item->id === (int) $product->id;
                });
            }
        @endphp
        <tr>
            <td data-label="Chọn">
                <label for="check-product-{{ $item->id }}">
                    <input type="checkbox" {{ $checked ? 'checked' : '' }} id="check-product-{{ $item->id }}" class="d-none" c-single data-checked-main data-checked="id" value="{{ $item->id }}">
                    <span></span>
                </label>
            </td>
            <td data-label="Sản phẩm">
                <div class="item-product">
                    @include('image_loader.tiny', ['itemImage' => $item, 'key' => 'img'])
                    <p class="flex-1">{{ $item->name }}</p>
                </div>
            </td>
            <td data-label="Tồn kho">
                {{ $item->getAvailable() }}
            </td>
            @php
                $listPrice = $item->getPrice();
            @endphp
            <td data-label="Giá">
                @if ($listPrice->count() > 1)
                    {{ Currency::showMoney($listPrice->min()) }}
                    <p>~</p>
                    {{ Currency::showMoney($listPrice->max()) }}
                @else
                    {{ Currency::showMoney($listPrice->first()) }}
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="100%">
                Không có sản phẩm nào hợp lệ!
            </td>
        </tr>
    @endforelse
</tbody>
@if ($listItem->count() > 0 && $listItem->lastPage() > 1)
    <tfoot>
        <tr>
            <td colspan="100%" class="py-3">
                {{ $listItem->withQueryString()->links('vendor.pagination.pagination') }}
            </td>
        </tr>
    </tfoot>
@endif
