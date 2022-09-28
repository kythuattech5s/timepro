<p class="title font-bold text-[#252525] mb-4 2xl:text-[1.125rem]">Phương thức thanh toán</p>
<div class="list-method mb-6">
    @php
        $countShow = 0;
        $i = 0;
    @endphp
    @foreach ($listPaymentMethod as $key => $itemPaymentMethod)
        @if(isset($list_method_notshow) && is_array($list_method_notshow) && in_array(Support::show($itemPaymentMethod,'id'),$list_method_notshow))
            <?php continue; ?>
        @endif
        <label class="payment-method__item relative w-full block mb-4 last:mb-0">
            <input type="radio" name="payment_method" value="{{Support::show($itemPaymentMethod,'id')}}" class="opacity-0 absolute cursor-pointer" {{$i == 0 ? 'checked':''}}>
            <p class="payment-method__content relative">
                @include('image_loader.big',['itemImage'=>$itemPaymentMethod,'key'=>'img'])
                {{Support::show($itemPaymentMethod,'name')}}
            </p>
            <div class="method-des mt-4 pl-20 {{$countShow == 0 ? 'show':''}}">
                <div class="s-content mb-2">
                    {!!Support::show($itemPaymentMethod,'content')!!}
                </div>
                @if ($itemPaymentMethod->isPayWallet())
                    <div class="box-wallet flex items-center gap-4 border px-3 py-2 rounded">
                        <div class="wallet-balance">
                            <p class="title mb-1 text-[1rem] font-semibold">Số dư ví: <span class="price color-gradient text-[1.15rem] font-bold">{{Currency::showMoney($user->getAmountAvailable())}}</span></p>
                        </div>
                        <a href="{{ \VRoute::get('deposit_wallet') }}" title="Nạp tiền" class="btn btn-orange inline-flex items-center justify-center py-1 lg:px-5 px-4 rounded bg-gradient-to-r from-[#FE8C00] to-[#F83600] text-white self-center hover:text-[#fff]">
                            <svg width="25" height="24" class="mr-2 inline-block" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.5019 6.99832V5.9979C17.5019 4.89287 16.6061 3.99707 15.5011 3.99707H5.99714C4.61585 3.99707 3.49609 5.11682 3.49609 6.49811V18.5031C3.49609 19.8844 4.61585 21.0042 5.99714 21.0042H19.0026C20.3838 21.0042 21.5036 19.8844 21.5036 18.5031V8.99915C21.5036 7.89412 20.6078 6.99832 19.5028 6.99832H3.49609" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M17.5008 14.0012H15.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <span>Nạp tiền</span>
                        </a>
                    </div>
                @endif
            </div>
        </label>
        @php
            $i++;
            $countShow++;
        @endphp
    @endforeach
</div>