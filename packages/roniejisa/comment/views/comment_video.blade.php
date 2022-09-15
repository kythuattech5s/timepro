<div class="comment-box__content {{isset($class) ? $class : ''}}">
    @if(Auth::check())
        <p class="fs-3 f-bold cl-blue mb-05">Để lại bình luận hoặc câu hỏi</p>
    @else
        <a href="/dang-nhap" class="fs-3 f-bold cl-blue mb-05">Đăng nhập để gửi bình luận hoặc câu hỏi</a>
    @endif
    @include('commentRS::comment_form',['hasForm' => true, 'hasUpload' => false, 'hasRating' => false, 'map_table' => 'videos'])
    <p class="fs-3 f-bold mt-04">Các bình luận trước đó</p>
    <div class="comment-box__list" after>
        @include('commentRS::comment',['hasRep' => true])
    </div>
</div>
