<link href="tvs_theme/frontend/css/videojs-hls-quality-selector.css" rel="stylesheet">
<link href="tvs_theme/frontend/css/video-js.css" rel="stylesheet">
<link href="tvs_theme/frontend/css/youtube_skin.css" rel="stylesheet">
@if(isset($type) && $type == 'lessonVideo')
<link href="theme/frontend/css/khvideojs_custom.css" rel="stylesheet">
@endif
<meta name="csrf-token" content="{{ csrf_token() }}">