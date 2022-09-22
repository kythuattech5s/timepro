<h1 class="title mb-4 font-bold text-[#252525] 2xl:text-[1.125rem]">Thông tin đơn hàng</h1>
@foreach ($listItems as $item)
    <p class="flex items-center justify-between border-b-[1px] border-solid border-[#ebebeb] py-2">
        <span class="name-pro max-w-[60%] text-[0.875rem]">{{ Support::show($item->realItem, 'name') }} (Gói: {{ Support::show($item->itemTimePackage, 'name') }})</span>
        <span class="price text-[0.875rem]">{{ Currency::showMoney($item->price) }}</span>
    </p>
@endforeach
@if ($voucherCheck && $voucherCheck->voucher != null)
    <p class="mt-2 flex items-center justify-between font-semibold">
        <span class="title">Mã giảm giá:</span>
        <span class="total-price">{{ Currency::showMoney($voucherCheck->discount) }}</span>
    </p>
@endif
<p class="mt-2 flex items-center justify-between font-semibold">
    <span class="title">Tổng:</span>
    <span class="total-price">{{ Currency::showMoney($totalMoney) }}</span>
</p>
