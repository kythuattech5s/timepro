@foreach ($listItems as $question)
    <div item class="relative before:absolute before:top-12 before:left-[21px] before:h-[calc(100%_-_70px)] before:w-[1px] before:bg-[#D9D9D9] before:content-['']">
        <div class="flex gap-2">
            @php
                $user = $question->user;
            @endphp
            <img src="{%IMGV2.user.img.-1%}" alt="{%AIMGV2.user.img.alt%}" class="h-11 w-11 rounded-full object-cover" title="{%AIMGV2.user.img.title%}">
            <div class="flex-1">
                <div class="flex h-11 flex-col justify-between">
                    <p class="font-bold">{{ $user != null ? $user->name : 'Quản trị viên' }}</p>
                    <p class="text-xs text-[#888888]">{{ RSCustom::showTime($question->created_at) }}</p>
                </div>
                <p class="my-2">
                    {!! $question->content !!}
                </p>
                <div class="flex flex-wrap gap-4">
                    <a class="{{ $question->likes->first(function ($q) {
                        return $q->pivot->user_id == Auth::id();
                    }) != null
                        ? 'like'
                        : '' }} flex cursor-pointer items-center gap-[4px]" data-id="{-question.id-}" rs-qaa-like>
                        @include('commentRS::icon.like') <span>Thích</span>
                    </a>
                    <a type="button" data-id="{{ $question->id }}" data-placeholder="Trả lời bình luận" class="group flex cursor-pointer items-center gap-[4px] duration-300 hover:text-[#CD272F]" rs-qaa-reply>
                        @include('commentRS::icon.reply') <span> Trả lời</span></a>
                    <div class="w-full" rs-qaa-list-child>
                        @foreach ($question->questions as $item_child)
                            <div class="relative flex gap-2 before:absolute before:top-12 before:left-[21px] before:h-[calc(100%_-_70px)] before:w-[1px] before:bg-[#D9D9D9] before:content-['']">
                                @php
                                    $user = $item_child->user;
                                @endphp
                                <img src="{%IMGV2.user.img.-1%}" alt="{%AIMGV2.user.img.alt%}" class="h-11 w-11 rounded-full object-cover" title="{%AIMGV2.user.img.title%}">
                                <div class="flex-1">
                                    <div class="flex h-11 flex-col justify-between">
                                        <p class="font-bold">{{ $user != null ? $user->name : 'Quản trị viên' }}</p>
                                        <p class="text-xs text-[#888888]">{{ RSCustom::showTime($item_child->created_at) }}</p>
                                    </div>
                                    <p class="my-2">
                                        {!! $item_child->content !!}
                                    </p>
                                    <div class="flex flex-wrap gap-4">
                                        <a class="{{ $item_child->likes->first(function ($q) {
                                            return $q->pivot->user_id == Auth::id();
                                        }) != null
                                            ? 'like'
                                            : '' }} flex cursor-pointer items-center gap-[4px]" data-id="{-item_child.id-}" rs-qaa-like>
                                            @include('commentRS::icon.like') <span>Thích</span>
                                        </a>
                                        <a type="button" data-id="{{ $question->id }}" data-placeholder="Trả lời bình luận" class="group flex cursor-pointer items-center gap-[4px] duration-300 hover:text-[#CD272F]" rs-qaa-reply>
                                            @include('commentRS::icon.reply') <span> Trả lời</span></a>
                                        <div class="w-full" rs-qaa-list-child>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
@if (!$listItems->onLastPage())
    <button class="mx-auto mt-6 block w-fit text-[0.875rem] font-semibold text-[#252525]" rs-qaa-load-more data-table="{{ $map_table }}" data-id="{{ $map_id }}" data-next-page="{{ $listItems->currentPage() + 1 }}">Xem thêm <i class="fa fa-angle-down" aria-hidden="true"></i></button>
@endif
