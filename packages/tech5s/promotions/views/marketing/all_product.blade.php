@forelse($products as $product)
    @php
        $checked = $product_chooses->first(function ($id) use ($product) {
            return (int) $id === (int) $product->id;
        });
    @endphp
    <tr style="{{(isset($product_in_promotion) && $product_in_promotion && $checked) ? 'display:none' : ''}}" class="{{is_null($checked) ? '' : 'disabled'}}">
        <td>
            <label for="product-modal-{-product.id-}" style="display:block">
                <input type="checkbox" value="{-product.id-}" id="product-modal-{-product.id-}"
                    {{ is_null($checked) ? '' : 'checked no-check' }} c-single>
                <span></span>
            </label>
        </td>
        <td class="text-left d-flex align-items-center">
            <img src="{%IMGV2.product.img.-1%}" alt="{%AIMGV2.product.img.alt%}" title="{%AIMGV2.product.img.title%}">
            <a href="{-product.slug-}" target="_blank">
                {-product.name-}
            </a>
        </td>
        @php
            $listPrice = $product->getPrice();
        @endphp
        <td>
            @if($listPrice->count() > 1)
                {{Currency::showMoney($listPrice->min())}}
                <p>~</p>
                {{Currency::showMoney($listPrice->max())}}
            @else
                {{Currency::showMoney($listPrice->first())}}
            @endif
        </td>
    </tr>
@empty
    <tr class="no-result">
        <td colspan="100%" style="flex: 0 0 100%">Không có sản phẩm nào hợp lệ!</td>
    </tr>
@endforelse
