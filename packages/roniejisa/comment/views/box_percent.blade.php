@if (config('cmrsc_comment.style') == 'ONE')
	<div class="comment-box__percent">
		@include('commentRS::ratingScore')
		@include('commentRS::ratingList')
	</div>
@elseif(config('cmrsc_comment.style') == 'THREE')
	@include('commentRS::style.score_three')
@elseif(config('cmrsc_conmment.style') == 'FOUR')
    @include('commentRS::style.score_four')
@else
	@include('commentRS::style.score_two')
@endif
