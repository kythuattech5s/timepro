<div class='comment-box__score'>
    <div class="comment-score-big">
        {{$ratings['scoreAll']}}
    </div>
    <div class="comment-score-big__rating d-flex flex-column align-items-center me-3">
        <p><i class="fa fa-star"></i></p>
        <p class="comment-score-max">/5</p>
    </div>
    <div>
        <p class="comment-name-score">{{Support::show($ratings,'typePercent')}}</p>
        <p class="comment-total-rating">Dựa trên {{Support::show($ratings,'totalRating')}} bài đánh giá</p>
    </div>
</div>
