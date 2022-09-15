@extends('index')
@section('main')
<section class="container">
    @if (!$currentItem->isOwn(Auth::user()))
        @php
            $fisrtPackage = $currentItem->timePackage->first();
        @endphp
        <div class="buy-item-box">
            <span class="item-price-main"></span>
            <span class="item-price-sub"></span>
            <select class="select-time-package">
                @foreach ($currentItem->timePackage as $key => $itemTimePackage)
                    <option value="{{$itemTimePackage->id}}" data-price="{{Currency::showMoney($itemTimePackage->price)}}" data-subprice="{{$itemTimePackage->price_old > $itemTimePackage->price ? Currency::showMoney($itemTimePackage->price_old):''}}">{{$itemTimePackage->name}}</option>
                @endforeach
            </select>
            <button type="button" class="btn-buy-item" data-action="buy-now" data-type="course" data-id="{{$currentItem->id}}" data-package="{{$fisrtPackage->id}}">Đăng kí ngay</button>
            <button type="button" class="btn-buy-item" data-action="add-cart" data-type="course" data-id="{{$currentItem->id}}" data-package="{{$fisrtPackage->id}}">Thêm vào giỏ hàng</button>
        </div>
    @endif
</section>
@endsection
