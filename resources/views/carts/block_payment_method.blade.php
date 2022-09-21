<p class="title font-bold text-[#252525] mb-4 2xl:text-[1.125rem]">Phương thức thanh toán</p>
<div class="list-method mb-6">
    @php
        $countShow = 0;
    @endphp
    @foreach ($listPaymentMethod as $key => $itemPaymentMethod)
        @if(isset($list_method_notshow) && is_array($list_method_notshow) && in_array(Support::show($itemPaymentMethod,'id'),$list_method_notshow))
            <?php continue; ?>
        @endif
        <label class="payment-method__item relative w-full block mb-4 last:mb-0">
            <input type="radio" name="payment_method" value="{{Support::show($itemPaymentMethod,'id')}}" class="opacity-0 absolute cursor-pointer" {{$key == 0 ? 'checked':''}}>
            <p class="payment-method__content relative">
                @include('image_loader.big',['itemImage'=>$itemPaymentMethod,'key'=>'img'])
                {{Support::show($itemPaymentMethod,'name')}}
            </p>
            <div class="method-des mt-4 pl-20 {{$countShow == 0 ? 'show':''}}">
                <div class="s-content mb-2">
                    {!!Support::show($itemPaymentMethod,'content')!!}
                </div>
                @if ($itemPaymentMethod->isPayWallet())
                    <a href="{{ \VRoute::get('deposit_wallet') }}" title="Nạp tiền" class="btn btn-red-gradien inline-flex items-center justify-center font-semibold text-white py-2 px-4 rounded uppercase bg-[#CD272F] mb-4">Nạp tiền</a>
                @endif
            </div>
        </label>
        @php
            $countShow++;
        @endphp
    @endforeach
</div>