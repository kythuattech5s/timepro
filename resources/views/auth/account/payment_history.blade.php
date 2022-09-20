@php
    use \App\Models\OrderStatus;
@endphp
@extends('index')
@section('main')
<section class="2xl:py-8 py-6 bg-[#EEEAEA]">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-4 2xl:gap-8 gap-4">
            <div class="col-span-1">
                @include('auth.account.sidebar')
            </div>
            <div class="col-span-1 lg:col-span-3">
                <div class="box-content bg-white p-4 rounded 2xl:mb-6 mb-4 last:mb-0">
                    <p class="title text-center font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.25rem] text-[1rem] mb-4">Lịch sử thanh toán</p>
                    @if (count($listItems) > 0)
                        @foreach ($listItems as $itemOrder)
                            @php
                                $arrTypeName = collect();
                            @endphp
                            <div class="item-order__detail block lg:flex justify-between py-4 border-b-[1px] border-solid border-[#ebebeb]">
                                <div class="order-content flex-1 lg:max-w-[65%] mb-2 lg:mb-0">
                                    @foreach ($itemOrder->orderDetail as $itemOrderDetail)
                                        @php
                                            $realItem = $itemOrderDetail->getRealItem();
                                            $arrTypeName->push($itemOrderDetail->getTypeName());
                                        @endphp
                                        <div class="order block sm:flex gap-3 mb-4">
                                            <div class="image shrink-0 w-[11rem] mb-2 sm:mb-0">
                                                <a href="{{Support::show($itemOrderDetail,'slug')}}" title="{{Support::show($itemOrderDetail,'name')}}" class="img img__ block c-img rounded overflow-hidden pt-[55%]">
                                                    @include('image_loader.big',['itemImage'=>$itemOrderDetail,'key'=>'img'])
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h3>
                                                    <a href="{{Support::show($itemOrderDetail,'slug')}}" title="{{Support::show($itemOrderDetail,'name')}}" class="title font-bold 2xl:text-[1.25rem] text-[#252525] block mb-1">{{Support::show($itemOrderDetail,'name')}}</a>
                                                </h3>
                                                <div class="package-name mb-2">
                                                    <p>Gói: <span class="font-bold 2xl:text-[1rem]">{{Support::show($itemOrderDetail,'name_time_package')}}</span></p>
                                                </div>
                                                <div class="flex 2xl:gap-20 lg:gap-10 gap-4">
                                                    @if (isset($realItem) && $itemOrderDetail->type == 'course')
                                                        <div class="rating-order">
                                                            @if (isset($realItem->teacher))
                                                                <p class="text text-[#6A6A6A] text-[0.875rem] mb-1">{{Support::show($realItem->teacher,'name')}}</p>
                                                            @endif
                                                            <div class="rating-item mb-1">
                                                                <p class="rating">
                                                                    <span class="rating-box">
                                                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                        <span style="width:94%">
                                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                                        </span>
                                                                    </span>
                                                                </p>
                                                                <p>(10)</p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="form-price">
                                                        @if ($itemOrderDetail->price_old > $itemOrderDetail->price)
                                                            <p class="price-old text-[0.875rem] text-[#888] mb-1 line-through">{{Currency::showMoney($itemOrderDetail->price_old)}}</p>
                                                        @endif
                                                        <p class="price font-semibold text-[#252525]">{{Currency::showMoney($itemOrderDetail->price)}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="info-order block sm:flex justify-between gap-6">
                                        <div class="item mb-2 sm:mb-0">
                                            <p class="title font-bold text-[#252525] 2xl:text-[1.125rem] mb-2">
                                                Thông tin nhận hàng:
                                            </p>
                                            <p class="text">
                                                @php
                                                    $arrTypeName = $arrTypeName->unique();
                                                @endphp
                                                {{implode(', ',$arrTypeName->toArray())}} <span class="font-bold">{{Support::show($itemOrder->orderStatus,'action_product')}}</span> mở khóa cho tài khoản của bạn
                                            </p>
                                        </div>
                                        <div class="item">
                                            <p class="title font-bold text-[#252525] 2xl:text-[1.125rem] mb-2">
                                                Hình thức thanh toán:
                                            </p>
                                            <p class="text">
                                                Thanh toán qua: <strong class="font-semibold">{{Support::show($itemOrder->paymentMethod,'name')}}</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-action flex flex-col gap-4">
                                    @if ($itemOrder->order_status_id == OrderStatus::PAID)
                                        <span class="status inline-flex items-center justify-center font-semibold text-[#888] py-2 px-6 rounded bg-[#F2F2F2]">Thành công</span>
                                    @else
                                        <span class="status inline-flex items-center justify-center font-semibold text-[#fff] py-2 px-6 rounded bg-[#F44336]">Thất bại</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <div class="pagination">
                            {{$listItems->withQueryString()->links('bases.pagination')}}
                        </div>
                    @else
                        <p class="text-[1.125rem] text-center">Tạm thời chưa có đơn hàng nào</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection