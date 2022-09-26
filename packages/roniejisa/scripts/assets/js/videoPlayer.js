(() => {
    const listPreview = document.querySelectorAll("[video-preview]");
    listPreview.forEach((item) => {
        item.onclick = async (e) => {
            e.preventDefault();
            let id = item.dataset.id;
            const modal = document.createElement("div");
            modal.className =
                "fixed top-0 left-0 w-full h-full right-0 bottom-0 bg-[rgba(0,0,0,0.65)] z-[1000] flex items-center justify-center";
            document.body.style.overflow = "hidden";
            document.body.append(modal);
            const loading = `<style>.rsl-wave { font-size: var(--rs-l-size, 2rem); color: var(--rs-l-color, #ee4d2d); display: inline-flex; align-items: center; width: 1.25em; height: 1.25em; } .rsl-wave--icon { display: block; background: currentColor; border-radius: 99px; width: 0.25em; height: 0.25em; margin-right: 0.25em; margin-bottom: -0.25em; -webkit-animation: rsla_wave .56s linear infinite; animation: rsla_wave .56s linear infinite; -webkit-transform: translateY(.0001%); transform: translateY(.0001%); } @-webkit-keyframes rsla_wave { 50% { -webkit-transform: translateY(-0.25em); transform: translateY(-0.25em); } } @keyframes rsla_wave { 50% { -webkit-transform: translateY(-0.25em); transform: translateY(-0.25em); } } .rsl-wave--icon:nth-child(2) { -webkit-animation-delay: -.14s; animation-delay: -.14s; } .rsl-wave--icon:nth-child(3) { -webkit-animation-delay: -.28s; animation-delay: -.28s; margin-right: 0; }</style><div class="rsl-wave"> <span class="rsl-wave--icon"></span> <span class="rsl-wave--icon"></span> <span class="rsl-wave--icon"></span> </div>`;

            modal.innerHTML = loading;
            try {
                const res = await XHR.send({
                    url: "/get-video-src",
                    data: {
                        course_video_id: id,
                    },
                });
                if (res.src) {
                    modal.innerHTML = await `
                                <video
                                    class="video-js vjs-theme-city"
                                    id="my-video"
                                    controls
                                    preload="auto"
                                    width="1100"
                                    height="auto"
                                >
                                </video>
                            `;

                    var player = videojs("my-video", {
                        controls: true,
                        autoplay: true,
                        preload: "auto",
                    });

                    player.src({
                        src: res.src,
                        type: "video/mp4",
                    });

                    player.play();
                    const button = document.createElement("button");
                    button.className =
                        "absolute top-1 right-1 text-white p-3 opacity-50 hover:opacity-100 duration-300";
                    button.innerHTML = `<i class="fa fa-times" aria-hidden="true"></i>`;
                    button.onclick = () => {
                        player.dispose();
                        modal.remove();
                        document.body.style.overflow = null;
                    };
                    modal.append(button);
                } else {
                    modal.remove();
                    document.body.style.overflow = null;
                }
            } catch (e) {
                modal.remove();
                document.body.style.overflow = null;
            }
        };
    });
})();