<p class="comment-box__title mt-4">Đánh giá và bình luận</p>
<div class="comment-box__form pb-2">
    {{-- <p class="title-do-comment-box w-100 d-none">Để lại đánh giá của bạn</p> --}}
    @if (config('cmrsc_comment.checkUser', false))
        @php
            $user = Auth::user();
        @endphp
        <div class="comment-box__form-img"
             style="background-image:url('{%IMGV2.user.img.390x0%}')">
        </div>
    @endif
    <form action="{{ config('cmrsc_comment.url') }}" clear method="POST" class="formComment form-validate" parent=".form-alert-error" @if (config('cmrsc_comment.fields.hasImages')) gallery @endif enctype="multipart/form-data" data-success="COMMENT.receivedComment" check>
        @csrf
        <div class="mb-2 flex flex-col">
            @if (config('cmrsc_comment.hasRating', false))
                <div class="form-alert-error" m-required="Vui lòng đánh giá">
                    @include('commentRS::selectStar')
                </div>
            @endif
            @if (config('cmrsc_comment.fields.hasImages'))
                <ul class="gallery-preview" data-gallery>
                </ul>
            @endif
        </div>
        <input type="hidden" name="map_id" value="{-currentItem.id-}">
        <input type="hidden" name="map_table" value="{{ $map_table }}">
        <div>
            <textarea name="content" placeholder="Bình luận" m-required="Hãy để lại bình luận" cols="26" rules="required"></textarea>
        </div>
        <div class="formComment__action">
            <button class="btn btn--orange" type="submit">Bình luận</button>
            @if (config('cmrsc_comment.fields.hasImages'))
                <label for="formComment__file" class="formComment__label formComment__label--upload">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                    <span>Upload</span>
                    <input type="file" id="formComment__file" name="images" multiple input-file>
                </label>
            @endif
        </div>
    </form>
</div>
{{-- @endif --}}
