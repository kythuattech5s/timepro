 @foreach ($notifications as $item)
     @php
         $data = $item->data;
     @endphp
     <div class="item-notification @if ($item->read_at == null) no-read @endif flex items-center justify-between gap-4 border-t-[1px] border-solid border-[#ebebeb] py-2 last:border-b-[1px] lg:py-4" data-id="{{Support::show($item,'id')}}">
         <div class="content">
             <h3>
                 <a href="{{ Support::show($data, 'link') }}" title=" {{ Support::show($data, 'title') }}"
                    class="title mb-2 block font-semibold text-[#252525]">
                     {{ Support::show($data, 'title') }}
                 </a>
             </h3>
             <p class="time inline-flex items-center text-[0.875rem] text-[#888]"><img
                      src="theme/frontend/images/cal.svg"
                      class="mr-2 inline-block h-6 w-6 object-contain" alt="">{{ RSCustom::showTime($item->created_at) }}
             </p>
         </div>
         <a href="{{ Support::show($data, 'link') }}" title="Xem chi tiết"
            class="btn btn-red-gradien inline-flex items-center justify-center rounded border-[1px] border-solid border-[#F44336] bg-white py-2 px-5 font-semibold text-[#F44336] hover:bg-[#F44336] hover:text-white">
             Xem chi tiết
         </a>
     </div>
 @endforeach
