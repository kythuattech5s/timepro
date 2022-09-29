<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<base href="{{asset('/')}}">
	<title>Video</title>
</head>
<body>
		@include('tvs::video_css')
		{{--
		@php $media = \DB::table('media')->where('id', $tvsMapItem->video_media_map_id)->first(); @endphp
		--}}
		<script type="text/javascript"> var VIDEO_ID = {{$secretId}}</script>
		<video-js id="my_video_1" class="video-js vjs-default-skin vjs-16-9" controls preload="none" width="640" height="268" data-setup='{"poster":"{{request()->poster ?? ""}}"}'>
			<source src="{{route('tvs-video.playlist',['tvsMapItemId'=>$tvsMapItem->id])}}" type="application/x-mpegURL">
			{{--
			<source src="<?php echo url($media->path.$media->file_name) ?>" type="video/mp4"></source>
			--}}
		</video-js>
		@include('tvs::video_js')
		<script type="text/javascript">
			videojs('my_video_1');
			function actionPlayVideo() {
				videojs('my_video_1').play();
			}
		</script>
</body>
</html>
