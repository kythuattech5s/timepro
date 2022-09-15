class getImageOfVideo {
    constructor(path, secs, callback, data = []) {
        this.callback = callback;
        this.data = data;
        this.path = path;
        this.secs = secs;
        this.video = document.createElement("video");
    }

    init = () => {
        this.video.onloadedmetadata = () => {
            if ("function" === typeof this.secs) {
                this.secs = this.secs(this.video.duration);
            }
            this.video.currentTime = Math.min(
                Math.max(
                    0,
                    (this.secs < 0 ? this.video.duration : 0) + this.secs
                ),
                this.video.duration
            );
        };

        this.video.onseeked = (e) => {
            var canvas = document.createElement("canvas");
            canvas.height = this.video.videoHeight;
            canvas.width = this.video.videoWidth;
            var ctx = canvas.getContext("2d");
            ctx.drawImage(this.video, 0, 0, canvas.width, canvas.height);
            this.url = canvas.toDataURL();
            this.callback.call(this, this.url, ...this.data);
        };

        this.video.onerror = (e) => {
            this.callback.call(this, e, ...this.data);
        };

        this.video.src = this.path;
    };

    getUrl = async () => {
        setTimeout(() => {
            return this.url;
        }, 2000);
    };
}
