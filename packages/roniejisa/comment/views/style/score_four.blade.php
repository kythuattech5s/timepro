<div class='comment-box__score' three>
    <div class="rating-score">
        @php
            if(session()->getId() == ''){
                dd($ratings);
            }
        @endphp
        <p class="score-big">{{$ratings['scoreAll']}} <span><i class="fa fa-star"></i></span></p>
        <p class="count-comment mt-2">đánh giá</p>
    </div>
    @include('commentRS::ratingList')
    <button type="button" class="btn btn-danger" onclick="COMMENT.focusTextarea(this)" >Bình luận ngay</button>
</div>