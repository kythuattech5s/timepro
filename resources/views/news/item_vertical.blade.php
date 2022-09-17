<div class="item-new__thumbs">
    <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'name')}}" class="img img__ block c-img pt-[56%] mb-2 rounded overflow-hidden">
        @include('image_loader.big',['keyImage'=>'img','itemImage'=>$item])
    </a>
    <h3>
        <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'name')}}" class="title font-bold text-[#252525] 2xl:text-[1.125rem] block mb-2">
            {{Support::show($item,'name')}}
        </a>
    </h3>
    <ul class="time-new">
        <li
            class="text-[#888] text-[0.875rem] inline-flex items-center 2xl:mr-6 mr-4 last:mr-0">
            <i class="fa fa-calendar-o mr-2 text-[1.25rem]" aria-hidden="true"></i>
            <span>{{Support::show($item,'created_at')}}</span>
        </li>
        @if(Support::show($item,'count') != '')
        <li class="text-[#888] text-[0.875rem] inline-flex items-center 2xl:mr-6 mr-4 last:mr-0">
            <i class="fa fa-eye mr-2 text-[1.25rem]" aria-hidden="true"></i>
            <span>{{Support::show($item,'count')}}</span>
        </li>
        @endif
    </ul>
</div>