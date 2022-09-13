(function($){
    var defaults = {
		audioButtonClass: "audio_ques",
		autoPlay: null,
		codecs: [{
			name: "OGG",
			codec: 'audio/ogg; codecs="vorbis"'
		}, {
			name: "MP3",
			codec: 'audio/mpeg'
		}],		
		playingClass: "playing",
		onEndClass:"on-ended-audio",
		playStartCallback: null,
        audio_s :[],
		volume: 1
    },$el=null,
    audio_elm ={
        isPlaying:false,
        elm :null,
        elm_other:null,
        track:"",
        i:-1,
        eventAudio: function(elm){         
            if(audio_elm.isPlaying) elm.addClass(defaults.playingClass);
            else elm.removeClass(defaults.playingClass);
        },
        play: function(i){
            audio_elm.track =audio_elm.elm.attr("media");
            if(!defaults.audio_s[i]){
                defaults.audio_s[i] = new Audio("");				
                defaults.audio_s[i].id = "audio_"+i;
                defaults.audio_s[i].volume = defaults.volume;
                defaults.audio_s[i].loop ="";
                defaults.audio_s[i].src =audio_elm.track;
            }
            _methods.addListeners(defaults.audio_s[i]);
            defaults.audio_s[i].play();
            audio_elm.isPlaying=true;
            audio_elm.eventAudio(audio_elm.elm);
            audio_elm.elm_other = audio_elm.elm;
        },
        pause: function(i,elm){	
            defaults.audio_s[i].pause();
            defaults.audio_s[i].currentTime=0;
            audio_elm.isPlaying = false;		
            audio_elm.eventAudio(elm);
        },       
        onEnded: function(){
            i = audio_elm.i;
            defaults.audio_s[i].pause();
            defaults.audio_s[i].currentTime=0;
            audio_elm.isPlaying = false;		
            audio_elm.eventAudio(audio_elm.elm);
        },
        reset:function(){
            audio_elm.isPlaying=false;
            audio_elm.elm =null;
            audio_elm.elm_other =null;
            audio_elm.track="";
            audio_elm.i = -1;
            defaults.audio_s= [];
        },
        unbindClick:function(){
            $("." + defaults.audioButtonClass).unbind('click');
            audio_elm.triggerPause();
            audio_elm.reset();
        },
        triggerPause:function(){
            if(audio_elm.isPlaying){
                audio_elm.pause(audio_elm.i,audio_elm.elm);
            }
        }
    },
    _methods = {
        init: function(options){
            $.extend(defaults, options);
            $el = this;
            $("." + defaults.audioButtonClass).bind("click", function(i){	
                audio_elm.elm = $(this);
                _methods.updateTrackState();
            });	
        },
        updateTrackState: function(){	
            index_audio  =audio_elm.elm.index("." + defaults.audioButtonClass); 
            if(audio_elm.i == index_audio && audio_elm.isPlaying){
                audio_elm.pause(audio_elm.i,audio_elm.elm);
                audio_elm.elm_other = null;
            }else{
               if(audio_elm.elm_other  && audio_elm.isPlaying){
                audio_elm.pause(audio_elm.i,audio_elm.elm_other);
                    audio_elm.elm_other = null;
               }
               audio_elm.i = index_audio;
               audio_elm.play(audio_elm.i);
            }
        },
        addListeners: function(elm) {
            $(elm).bind({
                "ended":audio_elm.onEnded,
                "loadeddata": _methods.onLoaded,
            });
        },
        onLoaded:function(){
        },
        removeListeners: function(elm) {
            $(elm).unbind({
                "ended": audio_elm.onEnded
            });
        }
    };      
    $.fn.ubaPlayer = function(method){
		if (audio_elm[method]) {
			return audio_elm[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === "object" || !method) {
			return _methods.init.apply(this, arguments);
		} else {
			$.error("Method " + method + " does not exist on jquery.ubaPlayer");
		}
    };  
})(jQuery);