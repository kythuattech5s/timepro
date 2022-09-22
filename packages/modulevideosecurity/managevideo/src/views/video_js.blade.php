<script type="text/javascript" src="tvs_theme/frontend/js/video.js"></script>
<script type="text/javascript" src="tvs_theme/frontend/js/videojs-contrib-quality-levels.js"></script>
<script type="text/javascript" src="tvs_theme/frontend/js/videojs-hls-quality-selector.js"></script>
<script type="text/javascript" src="tvs_theme/frontend/js/videojs-http-streaming.js"></script>
@if(in_array(request()->ip(), config('app.ips')))
<script type="text/javascript" src="tvs_theme/frontend/js/techvideo.js" defer></script>
@else
<script type="text/javascript" src="tvs_theme/frontend/js/tech.video.min.js" defer></script>
@endif