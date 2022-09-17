@php
$deal = $item->dealSub()->where('deal_product_subs.deal_id',$currentItem->id)->first();
$checked = false;
if (isset($deal)) {
$checked = $deal->pivot->act == 1 ? true : false;
}
@endphp
<div class="item-child">
    <label for="product-{-item.id-}" style="display:block" class="c-hidden">
        <input type="checkbox" value="{-item.id-}" name="id" id="product-{-item.id-}" c-single>
        <span></span>
    </label>
    <div class="name-product">
        <a href="{-product.slug-}" target="_blank">
            {-item.name-}
            {{ isset($noProperty) && $noProperty ? '' : ' - ' . $item->getProperty() }}
        </a>
    </div>
    <div class="price-group">
        <p>
            {-item.price-}
            <del>({-item.price_old-})</del>
        </p>
    </div>
    <div class="price-group">
        <div class="price" data-price="{{ $item['price'] }}">
            <input type="text" value="{{ $deal->pivot->price ?? $item['price'] }}" name="price">
        </div>
        <span> Hoặc </span>
        <div class="percent">
            <input type="text" placeholder="% giảm" value="{{ $deal->pivot->percent ?? '' }}" name="percent">
        </div>
    </div>
    {{-- <div class="qty-current warehouse">
        {{ ($item->parent !== null ? $item->totalStock() : $item-> ?? ''}}
    </div> --}}
    <div class="limit-order">
        <input type="text" name="limit" value="{{ $deal->pivot->limit ?? '' }}">
    </div>
    <div class="order-item">
        <input type="text" name="ord" value="{{ $deal->pivot->ord ?? '' }}">
    </div>
    <div class="action-active">
        <label class="switch">
            <input type="checkbox" name="act" data-type-product="{{ $type }}" value="{{ $checked ? 1 : 0 }}" {{ $checked
                   ? 'checked' : '' }}>
            <span class="slider"></span>
        </label>
    </div>
    <div class="action-box">

    </div>
</div>