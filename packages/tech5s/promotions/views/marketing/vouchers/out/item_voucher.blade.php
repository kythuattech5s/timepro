@forelse ($vouchers as $voucher)
    @php
        $voucherClamped = $voucher->countUsage();
    @endphp
    <label class="voucher--box__list--item" for="voucher-{{$voucher->id}}" style="order: {{($voucherCurrent !== null && $voucherCurrent->id == $voucher->id) ? '1' : '2'}}">
        <input type="radio" name="voucher" value="{{$voucher->id}}" id="voucher-{{$voucher->id}}" {{($voucherCurrent !== null && $voucherCurrent->id == $voucher->id) ? 'checked' : ''}}>
        <span class="voucher--box__tag-checked" ></span>
        @include('template.image_loader.small',['itemImage' => $voucher,'key' => 'img'])
        <div class="voucher--item__content">
            <p class="voucher--item__title">{{ $voucher->getNameShowUser() }}</p>
            <p class="voucher--item__discount">
                @if($voucher->minimum_apply_voucher)
                <span class="min">Đơn tối thiểu
                    {{ number_format($voucher->minimum_apply_voucher / 1000, 0, ',', '.') }}K
                </span>
                @endif
                @if ($voucher->max_discount !== null)
                    <span class="max">tối đa
                        {{ number_format($voucher->max_discount / 1000, 0, ',', '.') }}K</span>
                @endif
            </p>
            @if ($voucher->limit !== null && $voucher->limit > 0)
                <p class="voucher--item__progress">
                    <span width="{{ round($voucherClamped / $voucher->limit) }}%"></span>
                </p>
            @endif
            <p class="voucher--item__expied">HSD: {{ RSCustom::showTime($voucher->expired_at) }}</p>
            @if(false)
            <button class="voucher--item__condition">Điều kiện</button>
            @endif
        </div>
    </label>
@empty
    <p class="voucher-list-no-result">Hiện tại chưa có voucher khuyến mãi nào!</p>
@endforelse
