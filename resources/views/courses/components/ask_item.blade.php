@foreach ($asks as $ask)
    <div>
        <div class="mb-2 flex gap-2">
            <p class="font-semibold text-[#252525]">{{ $ask->name }}</p>
            <span class="relative inline-flex text-[#888] before:mr-2 before:h-1 before:w-1 before:rounded-full before:bg-[#888] lg:text-[0.75rem]">{{ RSCustom::showTime($ask->created_at) }}</span>
        </div>
        <div class="mb-2 text-[#252525]">
            {!! $ask->content !!}
        </div>
        <div>
            <a type="button" data-placeholder="Trả lời bình luận" class="group flex cursor-pointer gap-[4px] duration-300 hover:text-[#CD272F]" rep-ask data-id="{{ $ask->id }}">
                @include('commentRS::icon.reply') <span> Trả lời</span></a>
            <a class="{{ $ask->likes->first(function ($q) {
                return $q->pivot->user_id == Auth::id();
            }) != null
                ? 'like'
                : '' }} flex cursor-pointer gap-[4px]" data-id="{-ask.id-}" like-ask>
                @include('commentRS::icon.like') <span>Thích</span>
            </a>
            @php
                $ask_childs = $ask->asks;
                
            @endphp
            <div class="w-full" list-ask-child>
                @foreach ($ask_childs as $ask_child)
                    @php
                        $user = $ask_child->user;
                    @endphp
                    <div>
                        <div>
                            @include('image_loader.big', ['itemImage' => $user])
                        </div>
                        <div>
                            <div>
                                <p>{!! $ask_child->user->name !!}</p>
                                <span>Đã trả lời</span>
                                <p>{{ RSCustom::showTime($ask_child->created_at) }}</p>
                            </div>
                            <div>
                                {!! $ask_child->content !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endforeach