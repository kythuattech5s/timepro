@php
$id = $name . '-' . (isset($item['id']) ? $item['id'] : $keyItem.'_file');
$media = json_decode($value);
@endphp
<div data-id="{{ $id }}">
    <label htmlFor="">{{ $type['label'] }}</label>
    <input type="hidden" id="{{ $id }}" data-name="{{ $key }}" value="{{ json_encode($media, JSON_UNESCAPED_UNICODE) }}" />
    <a href="/esystem/media/view?istiny={{ $id }}&callback=VIDEO_CHAPTER.callbackFile" class="iframe-btn">
        <p class="disabled" id="{{ $id }}">{{$media->file_name}}</p>
    </a>
    <div class="mt-3 grid grid-cols-2 gap-2">
        <a href="/esystem/media/view?istiny={{ $id }}&callback=VIDEO_CHAPTER.callbackFile" class="iframe-btn col-span-1 w-full bg-blue-500 p-2 text-center text-white" type="button">{{ $type['placeholder'] }}</a>
        <a class="col-span-1 w-full bg-red-600 p-2 text-center text-white" href="javascript:void(0)" remove-file="{{ $id }}">Xóa</a>
    </div>
</div>
