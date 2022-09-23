@extends('index')
@section('css')
<link rel="stylesheet" href="theme/frontend/js/flatpickr/flatpickr.min.css">
@endsection
@section('main')
<section class="2xl:py-8 py-6 bg-[#EEEAEA]">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-4 2xl:gap-8 gap-4">
            <div class="col-span-1">
                @include('auth.account.sidebar')
            </div>
            <div class="col-span-1 lg:col-span-3">
                <div class="box-content font-Averta bg-white 2xl:mb-6 mb-4 last:mb-0 rounded rounded-[0.3125rem] overflow-hidden 2xl:p-[1.5rem] md:p-[1.25rem] p-[0.5rem]">
                    <p class="2xl:text-[1.625rem] lg:text-[1.425rem] text-[1.125rem] text-[#252525] font-semibold md:text-center text-left">
                        Tổng quan
                    </p>
                    <div class="flex items-center justify-between border-b-[1px] border-b-[#EBEBEB] lg:pb-[1.25rem] pb-[1rem] mb-[1.2rem]">
                        <p class="surplus 2xl:text-[2.5rem] lg:text-[2rem] sm:text-[1.75rem] text-[1.5rem] color-gradient font-semibold">
                            Số dư: {{Currency::showMoney(Support::show($wallet,'amount_available'))}}
                        </p>
                        <a href="{{\VRoute::get('deposit_wallet')}}" title="Nạp tiền" class="btn btn-red-gradien inline-flex items-center justify-center font-semibold text-white py-2 px-4 rounded-[1.25rem] bg-gradient-to-r from-[#F44336] to-[#C62828] shadow-[0_6px_20px_rgba(178,30,37,.4)]">
                            Nạp tiền
                        </a>
                    </div>
                    <div class="box-log-withdraw">
                        <div class="flex flex-wrap justify-between items-center mb-[1.2rem] items-center">
                            <p class="font-semibold md:text-[1.125rem] text-[1rem] md:w-fit w-full md:mb-0 mb-3">Lịch sử giao dịch</p>
                            <form action="{{\VRoute::get('my_wallet')}}" method="GET" class="flex-1 frm flex justify-between rounded rounded-[1.875rem] overflow-hidden border-[1px] border-[#EBEBEB] overflow-hidden max-w-[21.5rem] ml-auto">
                                <div class="flex-1 flex items-center">
                                    @include('svg.icon_time')
                                    <input type="text" name="range_time" time_range_flatpickr class="text-[0.875rem] text-[#888888] bg-transparent focus:outline-none"/>
                                </div>
                                <span onclick="MORE_FUNCTION.exportHistoryWallet(this);" data-action="{{\VRoute::get('export_wallet')}}" class="btn btn-red-gradien inline-flex items-center justify-center font-semibold text-white py-2 px-4 rounded-[1.25rem] bg-gradient-to-r from-[#F44336] to-[#C62828] shadow-[0_6px_20px_rgba(178,30,37,.4)]">Xuất</span>
                            </form>
                        </div>
                        @if(count($walletTransactions) > 0)
                        <div class="grid grid-cols-3">
                            <div class="col-span-1 bg-[#F5F5F5] py-[0.5rem] px-2 text-center border-b-[1px] border-[#EBEBEB] text-[#252525]">
                                Thời gian
                            </div>
                            <div class="col-span-1 bg-[#F5F5F5] py-[0.5rem] px-2 text-center border-b-[1px] border-[#EBEBEB] text-[#252525]">
                                Đã nạp / Đã rút
                            </div>
                            <div class="col-span-1 bg-[#F5F5F5] py-[0.5rem] px-2 text-center border-b-[1px] border-[#EBEBEB] text-[#252525]">
                                Trạng thái
                            </div>
                            @foreach($walletTransactions as $itemWalletTransaction)
                            <div class="col-span-1 text-[#454545] py-[0.5rem] px-2 text-center border-b-[1px] border-[#EBEBEB]">
                                {{Support::show($itemWalletTransaction,'created_at')}}
                            </div>
                            @if(Support::show($itemWalletTransaction,'type') == App\Models\UserWalletTransactionType::DEPOSIT_MONEY_INTO_WALLET)
                            <div class="col-span-1 text-[#454545] py-[0.5rem] px-2 text-center border-b-[1px] border-[#EBEBEB]">
                                Nạp {{\Currency::showMoney(Support::show($itemWalletTransaction,'amount'))}}
                            </div>
                            @else
                            <div class="col-span-1 text-[#454545] py-[0.5rem] px-2 text-center border-b-[1px] border-[#EBEBEB]">
                                Trừ {{\Currency::showMoney(Support::show($itemWalletTransaction,'amount'))}}
                            </div>
                            @endif
                            <div class="col-span-1 text-[#454545] py-[0.5rem] px-2 text-center border-b-[1px] border-[#EBEBEB]">
                                @switch(Support::show($itemWalletTransaction,'status'))
	                                @case(0)
	                                    <p class="text-[#AEAEB0]">Đang chờ xử lý</p>
	                                    @break
	                                @case(1)
	                                    <p class="text-[#48C664]">Thành công</p>
	                                    @break
	                                @case(2)
	                                    <p class="text-[#dc3545]">Hủy giao dịch</p>
	                                    @break
	                            @endswitch
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center text-[20px]">
                        	Bạn chưa có giao dịch nào !
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('jsl')
<script src="theme/frontend/js/flatpickr/flatpickr.js" defer></script>
<script src="theme/frontend/js/flatpickr/vn.js" defer></script>
@endsection