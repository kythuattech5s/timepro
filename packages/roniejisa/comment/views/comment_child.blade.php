<div class="comment-item">
    <div class="comment-item__top">
        @php
            $user = $commentChild->user;
        @endphp
        @if (config('cmrsc_comment.hasAvatar',false))
            <div class="comment-item__img" style="background-image:url({%IMGV2.user.img.390x0%})" comment-skeleton>
            </div>
        @endif
        <div class="comment-item__info">
            <div class="comment-user__info">
                <p class="user-info__name" comment-skeleton>
                    {{ $user->name ?? $user->email ?? 'Quản trị viên' }}
                </p>
                <span class="comment-item__datetime" comment-skeleton>{{ RSCustom::showTime($commentChild->created_at, false) }}</span>
            </div>
            <div class="comment-item__content" comment-skeleton>
                {-commentChild.content-}
            </div>
        </div>
    </div>
</div>
