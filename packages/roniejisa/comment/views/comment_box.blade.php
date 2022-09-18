<div class="comment-box__content {{ config('cmrsc_comment.class') }}">
    <p class="title-medium__all font-bold cl-blue mb-5 ">{{ $comments->total() }} đánh giá cho khóa học Tìm khách hàng khó hay dễ?</p>
    @if (config('cmrsc_comment.hasShowTotal'))
        <div class="box-percent-load">
            @include('commentRS::box_percent')
        </div>
    @endif
    @if (config('cmrsc_comment.hasFilter'))
        <div class="comment-line"></div>
        <div class="comment-box__filter">
            @include('commentRS::comment_filter', ['map_table' => $map_table])
        </div>
    @endif
    <div class="comment-box__list" @if (config('cmrsc_comment.insertAfter')) after @endif>
        @include('commentRS::comment')
    </div>
    @if (config('cmrsc_comment.isPaginate'))
        {{ $comments->withQueryString()->links('vendor.pagination.pagination') }}
    @else
        @if ($comments->lastPage() > $comments->currentPage())
            <button type="button" class="more-comment" page-table="{{ $map_table }}" page-id="{-currentItem.id-}" page-current="{{ $comments->currentPage() }}">Xem thêm</button>
        @endif
    @endif
    @include('commentRS::comment_form', ['map_table' => $map_table])
</div>
