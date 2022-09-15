 <div class="comment-detail">
     <div class="comment-item">
         <div class="comment-item__top">
             @php
                 $user = $comment->user;
             @endphp
             <div class="comment-item__img" style="background-image:url({%IMGV2.user.img.390x0%})">
             </div>
             <div class="comment-item__info">
                 <p class="comment-item__name">
                     {{ $user->name }}
                     <span class="comment-item__datetime">{{ RSCustom::showTime($comment->created_at) }}</span>
                 </p>
                 @if ($comment->rating !== null)
                     @include('commentRS::rating', ['rating' => $comment->rating->rating * 20 . '%'])
                 @endif
             </div>
         </div>
         <div class="comment-item__content">
             {!! $comment->content !!}
             @php
                 $imgs = json_decode($comment->imgs, true);
             @endphp
             @if ($imgs !== null && count($imgs) > 0)
                 <ul class="comment-item__imgs">
                     @foreach ($imgs as $imgComment)
                         @php
                             $imgItem = new \stdClass();
                             $imgItem->img = json_encode($imgComment, JSON_UNESCAPED_UNICODE);
                         @endphp
                         <li class="img-responsive" data-src="{%IMGV2.imgItem.img.390x0%}">
                             <div class="comment-item__img" style="background-image:url({%IMGV2.imgItem.img.390x0%})">
                             </div>
                         </li>
                     @endforeach
                 </ul>
             @endif
         </div>
         {{-- <button class="comment-item__rep" data-id="{{ Support::show($comment, 'id') }}">Trả lời</button> --}}
         @php
             $commentChilds = $comment->childs;
         @endphp
         @if ($commentChilds->count() > 0)
             <div class="comment-child">
                 @foreach ($commentChilds as $comment_child)
                     <div class="comment-child__item">
                         @php
                             $user = $comment_child->user;
                             if ($user == null) {
                                 $user = new \stdClass();
                                 $user->img = \vanhenry\helpers\helpers\SettingHelper::getSetting('logo');
                                 $user->name = 'Quản trị viên';
                             }
                         @endphp
                         <div class="comment-item__img" style="background-image:url({%IMGV2.user.img.390x0%})"></div>
                         <div class="comment-child__body">
                             <div class="comment-item__info">
                                 <p class="comment-item__name {{ $comment_child->is_admin == 1 ? 'is--admin' : '' }}">{{ $user->name }}</p>
                                 <p class="comment-item__datetime">{{ RSCustom::showTime($comment_child->created_at) }}</p>
                             </div>
                             <div class="comment-item__content">
                                 {!! $comment_child->content !!}
                             </div>
                         </div>
                     </div>
                 @endforeach
             </div>
         @endif
     </div>
 </div>
