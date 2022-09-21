 @php
     $id = $name . '-' . $item['id'];
     $media = json_decode($value);
     
 @endphp
 <div data-id="{{ $id }}">
     <label htmlFor="">{{ $type['label'] }}</label>
     <input type="hidden" id="{{ $id }}" data-name="{{ $key }}" value="@if($media != null ){{ json_encode($media, JSON_UNESCAPED_UNICODE) }}@endif" />
     <input type="hidden" data-name="duration" value="{{ $item['duration'] }}" />

     <a href="/esystem/media/view?istiny={{ $id }}&callback=VIDEO_CHAPTER.callbackVideo" class="iframe-btn">
         <img @if(is_null($media)) no-video @endif src="@if($media != null ) /{{ $media->path . $media->file_name }} @else /admin/images/noimage.png @endif" alt="" class="h-auto w-full" />
     </a>
     <div class="mt-3 grid grid-cols-2 gap-2">
         <a href="/esystem/media/view?istiny={{ $id }}&callback=VIDEO_CHAPTER.callbackVideo" class="iframe-btn col-span-1 w-full bg-blue-500 p-2 text-center text-white" type="button">{{ $type['placeholder'] }}</a>
         <a class="col-span-1 w-full bg-red-600 p-2 text-center text-white" href="javascript:void(0)" remove-file="{{ $id }}">Xóa</a>
     </div>
 </div>
