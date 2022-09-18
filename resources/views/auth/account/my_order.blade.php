@php
    use \App\Models\OrderStatus;
@endphp
@extends('index')
@section('css')
<style>
    .tabs .active {
        border: 1px solid;
        border-image-slice: 1;
        border-image-source: linear-gradient(to right bottom,#f44336,#c62828);
    }
</style>
@endsection
@section('main')
<section class="2xl:py-8 py-6 bg-[#EEEAEA]">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-4 2xl:gap-8 gap-4">
            <div class="col-span-1">
                @include('auth.account.sidebar')
            </div>
            <div class="col-span-1 lg:col-span-3">
                <div class="box-content bg-white p-4 rounded 2xl:mb-6 mb-4 last:mb-0">
                    <p
                        class="title text-center font-bold text-[#252525] 2xl:text-[1.6rem] lg:text-[1.25rem] text-[1rem] mb-4">
                        Quản lý đơn hàng
                    </p>
                    <div class="button-tabs tab-info-lesson justify-center text-center block border-b-[1px] border-solid border-[#ebebeb] 2xl:px-20 lg:px-10 px-4 2xl:mb-6 mb-4">
                        @foreach ($listOrderStatus as $item)
                            <a href="{{\VRoute::get("my_order")}}/{{$item->action}}" class="tablinks inline-block font-bold 2xl:text-[1.25rem] py-4 border-b-[2px] border-solid border-transparent 2xl:mr-16 lg:mr-8 mr-4 last:mr-0 {{$activeStatus == $item->id ? 'active':''}}">{{$item->user_view_name}}</a>
                        @endforeach
                    </div>
                    <div class="wrapper_tabcontent mb-4">
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
                                    @if ($itemOrder->order_status_id == OrderStatus::WAIT_PAYMENT)
                                        <span class="status inline-flex items-center justify-center font-semibold text-[#888] py-2 px-6 rounded bg-[#F2F2F2]">Đang xử lý</span>
                                        <a href="javascript:void(0)" onclick="MORE_FUNCTION.showModal(this);" data-modal="cancelOrder" title="Hủy đơn" class="btn btn-red-gradien inline-flex items-center justify-center font-semibold text-white py-2 px-6 rounded bg-gradient-to-r from-[#F44336] to-[#C62828]">Hủy đơn</a>
                                    @endif
                                    @if ($itemOrder->order_status_id == OrderStatus::PAID)
                                        <a href="javascript:void(0)" title="Đánh giá" class="btn btn-red-gradien inline-flex items-center justify-center font-semibold text-white py-2 px-6 rounded bg-gradient-to-r from-[#F44336] to-[#C62828]">Đánh giá</a>
                                    @endif
                                    @if ($itemOrder->order_status_id == OrderStatus::CANCEL)
                                        <a href="javascript:void(0)" title="Mua lại" class="btn btn-red-gradien inline-flex items-center justify-center font-semibold text-white py-2 px-6 rounded bg-gradient-to-r from-[#F44336] to-[#C62828] btn-restore-order" data-order="{{$itemOrder->id}}">Mua lại</a>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            <div class="pagination">
                                {{$listItems->withQueryString()->links('bases.pagination')}}
                            </div>
                        @else
                            <div class="bg-white rounded p-3">
                                <p class="text-[1.125rem]">Tạm thời chưa có đơn hàng nào</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- <div id="cancelOrder" modal tabindex="-1" aria-hidden="true" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full d-none">
    <div class="relative p-4 w-full max-w-[34rem] h-full md:h-auto mx-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-[0.625rem] right-[0.625rem] z-10 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="defaultModal" button_close_modal>
                @include('svg.icon_close')
            </button>
        </div>
    </div>
</div> --}}
@endsection
@section('js')
    <script src="{{ Support::asset('theme/frontend/js/user_course_control.js') }}" defer></script>
@endsection