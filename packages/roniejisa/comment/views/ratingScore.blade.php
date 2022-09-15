<div class="rating-score">
    <p class="score-big">{{$ratings['scoreAll']}}</p>
    @include('commentRS::rating',['rating'=>$ratings['percentAll'].'%'])
    <p class="count-comment mt-2">{{$ratings['totalRating']}} đánh giá</p>
</div>
