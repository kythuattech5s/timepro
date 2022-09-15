@forelse($comments as $comment)
    @include('commentRS::item')
@empty
    <div class="no-result">
        Chưa có bài đánh giá.
    </div>
@endforelse
