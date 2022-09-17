@php
$flash_sale = isset($action) && in_array($action, ['edit', 'copy']) ? $item->flash_sale->first() : null;
$checked = false;
if ($flash_sale !== null && $flash_sale->pivot->act == 1) {
    $checked = true;
}
@endphp
<div class="item-child">
    <label for="product-{-item.id-}" style="display:block">
        <input type="checkbox" value="{-item.id-}" name="id" id="product-{-item.id-}" c-single
            {{ $checked ? 'disabled' : '' }}>
        <span></span>
    </label>
    <div class="name-product">
        <a href="{-product.slug-}" target="_blank">
            {-item.name-}
            {{-- {-item.name-}{{ isset($noProperty) && $noProperty ? '' : ' - ' . $item->getProperty($product) }} --}}
        </a>
    </div>
    <div class="price-group">
        <p>
            <strong>{-item.price-}</strong>
            <del>({-item.price_old-})</del>
        </p>
    </div>
    <div class="price-group">
        <div class="price" data-price="{{ $item['price'] }}">
            <input type="text" value="{{ $flash_sale->pivot->price ?? $item['price'] }}" name="price"
                {{ $checked ? 'disabled' : '' }}>
        </div>
        <span> Hoặc </span>
        <div class="percent">
            <input type="text" placeholder="% giảm" name="percent" value="{{ $flash_sale->pivot->percent ?? '' }}"
                {{ $checked ? 'disabled' : '' }}>
        </div>
    </div>
    <div class="quantity-product">
        <input type="text" placeholder="Số lượng" name="qty" value="{{ $flash_sale->pivot->qty ?? '' }}"
            {{ $checked ? 'disabled' : '' }}>
    </div>
    <div class="qty-current warehouse">
        {-item.quantity-}
    </div>
    <div class="limit">
    </div>
    <div class="active-action">
        <label class="switch">
            <input type="checkbox" name="act" value="{{ $checked ? 1 : 0 }}" {{ $checked ? 'checked' : '' }}>
            <span class="slider"></span>
        </label>
    </div>
    <div class="action-box">

    </div>
</div>
