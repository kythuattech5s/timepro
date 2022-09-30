(function(window, videojs) {

	var player = window.player = videojs('my_video_1',{

		playbackRates: [0.25 ,0.5 , 1, 1.5, 2]

	});

	player.hlsQualitySelector({

		displayCurrentQuality: true,

	});
	console.log(1);
	setTimeout(function(){
	if( window.player.tech_.hls && window.player.tech_.hls.xhr){
		console.log('true');
	}
	else{
		console.log('false');
	}

	},2000);

}(window, window.videojs));