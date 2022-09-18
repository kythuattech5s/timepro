@foreach ($asks as $ask)
    <div>
        <div class="mb-2 flex gap-2">
            <p class="font-semibold text-[#252525]">{{ $ask->name }}</p>
            <span class="relative inline-flex items-center text-[#888] before:mr-2 before:h-1 before:w-1 before:rounded-full before:bg-[#888] lg:text-[0.75rem]">{{ RSCustom::showTime($ask->created_at) }}</span>
        </div>
        <div class="mb-2 text-[#252525]">
            {!! $ask->content !!}
        </div>
        <div class="flex flex-wrap gap-4 pl-6 lg:pl-14">
            <a type="button" data-id="{{ $ask->id }}" data-placeholder="Trả lời bình luận" class="group flex cursor-pointer items-center gap-[4px] duration-300 hover:text-[#CD272F]" rs-qaa-reply>
                @include('commentRS::icon.reply') <span> Trả lời</span></a>
            <a class="{{ $ask->likes->first(function ($q) {
                return $q->pivot->user_id == Auth::id();
            }) != null
                ? 'like'
                : '' }} flex cursor-pointer items-center gap-[4px]" data-id="{-ask.id-}" rs-qaa-like>
                @include('commentRS::icon.like') <span>Thích</span>
            </a>
            @php
                $ask_childs = $ask->asks;
            @endphp
            <div class="w-full" rs-qaa-list-child>
                @foreach ($ask_childs as $ask_child)
                    <div class="mb-4 flex gap-3 last:mb-0">
                        <div class="img-ava h-12 w-12 shrink-0 overflow-hidden rounded-full">

                            <img src="" alt="">
                        </div>
                        <div>
                            <div class="mb-2 flex flex-wrap items-center gap-2">
                                <p>{!! $ask_child->user->name !!}</p>
                                <span class="relative pl-3 text-[#F44336] after:absolute after:left-0 after:top-1/2 after:h-1 after:w-1 after:-translate-y-1/2 after:rounded-full after:bg-[#F44336]">Đã trả lời</span>
                                <p class="relative pl-3 text-[#888] after:absolute after:top-1/2 after:left-0 after:h-1 after:w-1 after:-translate-y-1/2 after:rounded-full after:bg-[#888]">{{ RSCustom::showTime($ask_child->created_at) }}</p>
                            </div>
                            <div class="text-[#252525]">
                                {!! $ask_child->content !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endforeach
