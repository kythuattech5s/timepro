<script type="text/javascript" src="tvs_theme/frontend/js/video.js" defer></script>
<script type="text/javascript" src="tvs_theme/frontend/js/videojs-contrib-quality-levels.js" defer></script>
<script type="text/javascript" src="tvs_theme/frontend/js/videojs-hls-quality-selector.js" defer></script>
<script type="text/javascript" src="tvs_theme/frontend/js/videojs-http-streaming.js" defer></script>
@if(in_array(request()->ip(), ['8.21.11.5','14.160.24.158']))
<script type="text/javascript" src="tvs_theme/frontend/js/techvideo.js" defer></script>
@else
<script type="text/javascript" src="tvs_theme/frontend/js/tech.video.min.js" defer></script>
@endif