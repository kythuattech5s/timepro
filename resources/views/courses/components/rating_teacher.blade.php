    <p class="title mb-2 text-center text-[1rem] font-bold text-[#252525] 2xl:text-[1.3rem]">
        Đánh giá giảng viên
    </p>
    <div class="flex items-center justify-center">
        @php
            $rating = $comment->rating;
        @endphp
        @if($rating != null)
        <span class="font-bold"></span> @include('commentRS::rating', ['size' => 32, 'rating' => $rating->rating * 5 . '%'])
        @endif
    </div>
    <div><span class="font-bold">Nội dung:</span>
        <p>{!! $comment->content !!}</p>
    </div>
