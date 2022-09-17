<div class="item-new sm:flex items-center lg:gap-4 gap-2 2xl:py-4 py-2 border-b-[1px] border-solid border-[#ebebeb] first:border-t-[1px]">
    <div class="image shrink-0 md:w-[18.75rem] sm:w-[14rem] mb-2 sm:mb-0">
        <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'name')}}" class="img img__ c-img block pt-[56%] rounded overflow-hidden">
            @include('image_loader.big',['keyImage'=>'img','itemImage'=>$item])
        </a>
    </div>
    <div class="new-content">
        <h3>
            <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'name')}}" class="title block font-bold text-[#252525] mb-2 2xl:text-[1.25rem]">
                {{Support::show($item,'slug')}}
            </a>
        </h3>
        <div class="short_content line-clamp-3 mb-2">
            {{Support::show($item,'short_content')}}
        </div>
        <ul class="time-new">
            <li
                class="text-[#888] text-[0.875rem] inline-flex items-center 2xl:mr-6 mr-4 last:mr-0">
                <i class="fa fa-calendar-o mr-2 text-[1.25rem]" aria-hidden="true"></i>
                <span>{{Support::show($item,'created_at')}}</span>
            </li>
            @if(Support::show($item,'count') != '')
            <li
                class="text-[#888] text-[0.875rem] inline-flex items-center 2xl:mr-6 mr-4 last:mr-0">
                <i class="fa fa-eye mr-2 text-[1.25rem]" aria-hidden="true"></i>
                <span>{{Support::show($item,'count')}}</span>
            </li>
            @endif
        </ul>
    </div>
</div>