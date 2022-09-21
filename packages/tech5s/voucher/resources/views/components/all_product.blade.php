@forelse($listItems as $item)
    @php
        $checked = $item_chooses->first(fn($itemChoose) => isset($itemChoose['id']) && (int) $itemChoose['id'] === (int) $item->id);
        $flagChecking = !isset($item_checked_old) || (isset($item_checked_old) && $item_checked_old->first(fn($itemChecked) => isset($itemChecked['id']) && (int) $itemChecked['id'] === (int) $item->id));
    @endphp
    <tr class="@if ($checked !== null && $flagChecking) disabled @endif">
        <td>
            @if ($checked !== null && $flagChecking)
                <input type="hidden" name="disabled" value="1" data-checked="disabled">
            @endif
            <label for="product-modal-{-item.id-}" style="display:block">
                <input type="checkbox" value="{-item.id-}" id="product-modal-{-item.id-}" @if ($checked !== null) checked no-check @endif c-single data-checked="id" data-checked-main>
                <span></span>
            </label>
        </td>
        <td class="d-flex align-items-center text-left">
            <img src="{%IMGV2.item.img.-1%}" alt="{%AIMGV2.item.img.alt%}" title="{%AIMGV2.item.img.title%}">
            <a href="{-item.slug-}" target="_blank">
                {-item.name-}
            </a>
        </td>
        @php
            $listPrice = FlashSaleHelper::getPriceOfItem($item);
        @endphp
        <td>
            @if ($listPrice['max'] > 0 && $listPrice['min'] < $listPrice['max'])
                {{ $listPrice['min'] }} ~ {{ $listPrice['max'] }}
            @else
                {{ $listPrice['min'] }}
            @endif
        </td>
    </tr>
@empty
    <tr class="no-result">
        <td colspan="100%" style="flex: 0 0 100%">Không có sản phẩm nào hợp lệ!</td>
    </tr>
@endforelse
