var Tech5sVideo = {
    baseUrl: "",
    player:null,
    isPlaying:false,
    init: function () {
        this.baseUrl = document.querySelector("base").getAttribute("href");
        this.initPlayer();
        var self = this;
        setTimeout(function(){
            self.initVideoJs();     
            self.initEvent();     
        },500);
        
    },
    initPlayer:function(){
        videojs.options.hls.overrideNative = true;
        videojs.options.html5.nativeAudioTracks = false;
        videojs.options.html5.nativeVideoTracks = false;
		this.player = window.Player = videojs('my_video_1',
        {
            playbackRates: [0.25 ,0.5 , 1, 1.5, 2],
            "preload": 'metadata',
              // html5: {
              //   hls: {
              //     overrideNative: true
              //   },
              //   vhs: {
              //       withCredentials: true,
              //       overrideNative: false
              //   }
              // }
            }
        );

		this.player.hlsQualitySelector({
			displayCurrentQuality: true,

		});

    },
    initEvent : function(){
        this.player.on('play',function(e){
            var obj = JSON.parse(JSON.stringify({type:"TECH5S_VIDEO_PLAY",event:e,video_id:VIDEO_ID}));
            window.parent.postMessage(obj, "*")
        });
        this.player.on('pause',function(e){
            var obj = JSON.parse(JSON.stringify({type:"TECH5S_VIDEO_PAUSE",event:e,video_id:VIDEO_ID}));
            window.parent.postMessage(obj, "*")
        });
        this.player.on('ended',function(e){
            var obj = JSON.parse(JSON.stringify({type:"TECH5S_VIDEO_ENDED",event:e,video_id:VIDEO_ID}));
            window.parent.postMessage(obj, "*")
        });
        this.player.on('error',function(e){
            var obj = JSON.parse(JSON.stringify({type:"TECH5S_VIDEO_ERROR",event:e,video_id:VIDEO_ID}));
            window.parent.postMessage(obj, "*")
        });
        this.player.on('seeked',function(e){
            var obj = JSON.parse(JSON.stringify({type:"TECH5S_VIDEO_SEEKED",event:e,video_id:VIDEO_ID}));
            window.parent.postMessage(obj, "*")
        });
        this.player.on('seeking',function(e){
            var obj = JSON.parse(JSON.stringify({type:"TECH5S_VIDEO_SEEKING",event:e,video_id:VIDEO_ID}));
            window.parent.postMessage(obj, "*")
        });
    },
    fetchGet: function (url) {
        var request = new XMLHttpRequest();
        request.open("GET", url, false);
        request.send(null);
        var result = "";
        if (request.status === 200) {
            result = request.responseText;
        }
        try {
            result = JSON.parse(result);
        } catch (error) {
            result = {};
        }
        return result;
    },
    fetchPost : function(url,data){
        var result = "";
        var xhr = new XMLHttpRequest();
        xhr.open("POST", url , false);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                result = xhr.responseText;
            }
        }
        if (!Object.entries) {
          Object.entries = function( obj ){
            var ownProps = Object.keys( obj ),
                i = ownProps.length,
                resArray = new Array(i);
            while (i--)
              resArray[i] = [ownProps[i], obj[ownProps[i]]];

            return resArray;
          };
        }
        var params = Object.entries(data);
        var postData = null;
        if(params.length>0){
            postData = "";
            for (var i = 0; i < params.length; i++) {
                var param = params[i];
                postData +=param[0]+"="+param[1];
                if(i<params.length-1){
                    postData+= "&";
                }
            }    
        }
        xhr.send(postData);
        try {
            result = JSON.parse(result);
        } catch (error) {
            result = {};
        }
        return result;
    },
    makeToken: function (rawToken) {
        rawToken = this.rot13(rawToken);
        var result = "";
        var salt = "123456780ABCDEFGHKLMNOPYTRQW";
        for (var i = 0; i < rawToken.length; i++) {
            if (i % 2 == 0) {
                result += rawToken[i];
            } else {
                result += salt[Math.floor(Math.random() * salt.length)];
                result += rawToken[i];
            }
        }

        return (result);
    },
    rot13:function(str){
        return str.replace(/[a-zA-Z]/g, function(c){
            return String.fromCharCode((c <= "Z" ? 90 : 122) >= (c = c.charCodeAt(0) + 13) ? c : c - 26);
        });
    },
    lastPathUrl: function (url) {
        return url.substring(url.lastIndexOf("/") + 1);
    },
    initVideoJs: function () {
        if (typeof videojs == "undefined") return;
        var self = this;
        if (this.player.tech_ && this.player.tech_.vhs) {
            videojs.Vhs.xhr.beforeRequest = function (options) {
                var uri = options.uri;
                var u = new URL(uri);
                if (uri.indexOf(".ts") >= 0) {
                    var url = new URL(options.uri);
                    var nimble = url.searchParams.get("nimblesessionid");
                    var p0 = Math.random().toString(36);
                    var p1 = encodeURI(
                        btoa(btoa(uri)).split("").reverse().join("")
                    );
                    var fullUrl =
                        self.baseUrl +
                        "tvs-video/fetch?sid=" +
                        VIDEO_ID +
                        "&p0=" +
                        p0 +
                        "&p1=" +
                        p1 +
                        "&path=" +
                        self.lastPathUrl(u.pathname)+
                        "&session="+u.searchParams.get('session')
                    var objToken = self.fetchGet(fullUrl);
                    var token = objToken.token || "";
                    token = self.makeToken(token);
                    options.uri +=
                        "&p0=" +
                        p0 +
                        "&p1=" +
                        p1 +
                        "&token=" +
                        token;
                }
                return options;
            };
        }
        else{

        }
    },

    mobileLoadMetadata:function(){
        var self = this;
        self.waitForStreamkey()
    },
    getSourcePlayer:function(){
        var mediaSource = this.player.currentSource();
        var source = '';
        if (mediaSource) {
            source = mediaSource.src
        }
        return source;
    }
    ,
    currentPlaybackid :0
    ,
    waitForStreamkey : function() {
        var self = this;
        var source = this.getSourcePlayer();
        var result = this.fetchPost(this.baseUrl+"tvs-video/point",{file:source});
        this.currentPlaybackid = result.play;
        if(this.currentPlaybackid>0){
            this.reQuestKeyForStream();
        }
        else{
            setTimeout(function () {
                self.waitForStreamkey()
            }, 1000)
        }
    },
    needRequest:true,
    reQuestKeyForStream : function() {
        if (!this.needRequest) {
            return;
        };
        var source = this.getSourcePlayer();
        var self = this;
        this.needRequest = true;
        var result = this.fetchPost(this.baseUrl+"tvs-video/press",{file:source,play:this.currentPlaybackid});
          
    }
};
Tech5sVideo.init();