<div style="width:500px">
	@php

	$fileInfo = \VideoSetting::jsonDecode($video_info);

	$attachmentId = isset($fileInfo['id']) ? (int)$fileInfo['id']:0;
	$secretMedia = \modulevideosecurity\managevideo\Models\TvsSecret::where('media_id',$attachmentId)->orderBy('id','desc')->first();

	@endphp
	@if($secretMedia)
	<video-js id="my_video_1" class="video-js vjs-default-skin vjs-4-3" controls preload="none" width="640" height="268">

		<source src="{{route('tvs-video.playlist',['secretId'=>$secretMedia->id])}}" type="application/x-mpegURL">

	</video-js>
	@endif

</div>

<script type="text/javascript"> var VIDEO_ID = {{$secretMedia->id}}</script>