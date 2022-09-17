<div class="item-new flex items-center gap-2">
    <div class="image shrink-0 sm:w-[11.75rem] w-[9.75rem]">
        <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'name')}}" class="img img__ c-img block pt-[56%] rounded overflow-hidden">
            @include('image_loader.tiny',['keyImage'=>'img','itemImage'=>$item])
        </a>
    </div>
    <div class="new-content">
        <h3>
            <a href="{{Support::show($item,'slug')}}" title="{{Support::show($item,'name')}}" class="title block text-[#252525] mb-2">
                {{Support::show($item,'name')}}
            </a>
        </h3>
        <ul class="time-new">
            <li
                class="text-[#888] lg:text-[0.875rem] inline-flex items-center 2xl:mr-6 mr-4 last:mr-0">
                <i class="fa fa-calendar-o mr-2 lg:text-[1.25rem]" aria-hidden="true"></i>
                <span>{{Support::show($item,'created_at')}}</span>
            </li>
            @if(Support::show($item,'count') != '')
            <li
                class="text-[#888] lg:text-[0.875rem] inline-flex items-center 2xl:mr-6 mr-4 last:mr-0">
                <i class="fa fa-eye mr-2 lg:text-[1.25rem]" aria-hidden="true"></i>
                <span>{{Support::show($item,'count')}}</span>
            </li>
            @endif
        </ul>
    </div>
</div>