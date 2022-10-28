import Helper from "../../../../roniejisa/scripts/assets/js/Helper.js";
(() => {
    const load = () => {
        const video = document.querySelector("video");
        if (!video) return;
        video.onplay = handleEventVideo;
        video.onpause = handleEventVideo;
        document.addEventListener("visibilitychange", (e) =>
            eventSwitchTab(e, video)
        );
    };

    const eventSwitchTab = (e, video) => {
        if (document.visibilityState == "visible") {
            //    videojs("my_video_1").pause()
        } else {
            videojs("my_video_1").pause();
        }
    };

    const handleEventVideo = (e) => {
        const video = e.target;
        const { currentTime } = video;
        XHR.send({
            url: "danh-dau-da-hoc-xong",
            method: "POST",
            data: {
                course_video_id: video.dataset.id,
                duration: currentTime,
            },
        }).then((res) => {
            const listVideo = document.querySelectorAll("[data-link]");
            listVideo.forEach((item) => {
                if (video.dataset.id == item.dataset.id) {
                    item.classList.add("playing");
                } else if (item.classList.contains("playing")) {
                    item.classList.remove("playing");
                }
            });
        });
    };

    const changeVideo = () => {
        let timeout;
        const video = document.querySelector("video");

        if (!video) return;

        const listVideo = document.querySelectorAll("[data-link]");
        listVideo.forEach((item) => {
            item.onclick = () => {
                if (video.dataset.id == item.dataset.id) return;
                clearTimeout(timeout);
                timeout = setTimeout(async () => {
                    document.addEventListener(
                        "visibilitychange",
                        eventSwitchTab
                    );
                    const res = await XHR.send({
                        url: `/get-video-src?course_video_id=${item.dataset.id}`,
                        method: "get",
                    });
                    if (typeof VIDEO_ID != "undefined") {
                        VIDEO_ID = res.secretId;
                    }
                    const parent = video.closest(".video-lesson");
                    const html = `<video-js id="my_video_1" class="video-js vjs-default-skin vjs-16-9" controls preload="none" data-id="${item.dataset.id}" width="640" height="268" poster="${res.poster}">
                            <source src="${res.src}" type="application/x-mpegURL">
                        </video-js>`;
                    video.parentElement.remove();
                    await videojs("my_video_1").dispose();
                    parent.innerHTML = await html;
                    Tech5sVideo.init();
                    load();
                    checkTime();
                    changeVideo();
                    toTime();
                    catchEventVideo();
                    showRatingForm();
                    backToCourse();
                    showListNote(item.dataset.id, item, video);
                }, 400);
            };
        });
    };

    const showListNote = (id, item, video) => {
        XHR.send({
            url: "lay-danh-sach-ghi-chu",
            method: "POST",
            data: {
                course_video_id: id,
            },
        }).then((res) => {
            // video.querySelector("source").src = item.dataset.link;
            video.dataset.id = id;
            document.querySelector("[list-note]").innerHTML = res.html;
            toTime();
            video.load();
            video.play();
        });
    };

    const catchEventVideo = () => {
        const video = document.querySelector("video");
        if (!video) return;
        video.onended = (e) => {
            const listVideo = document.querySelectorAll("[data-link]");
            XHR.send({
                url: "danh-dau-da-hoc-xong",
                method: "POST",
                data: {
                    course_video_id: video.dataset.id,
                    is_done: 1,
                    duration: video.currentTime,
                },
            }).then(async (res) => {
                let index;
                listVideo.forEach((item, i) => {
                    if (video.dataset.id == item.dataset.id) {
                        index = i;
                    }
                });
                listVideo[index].classList.add("active");
                if (listVideo[index].classList.contains("playing")) {
                    listVideo[index].classList.remove("playing");
                }
                if (index >= listVideo.length - 1) {
                    video.pause();
                    const buttonRatingHTML = `<button rating-course class="btn btn-red-gradien mx-auto flex w-fit items-center justify-center rounded bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-4 font-semibold uppercase text-white shadow-[0_6px_20px_rgba(178,30,37,.4)]">Đánh giá khóa học</button>`;
                    if (
                        !listVideo[listVideo.length - 1]
                            .closest(".list-lesson__item")
                            .parentElement.querySelector(
                                "button[rating-course]"
                            )
                    ) {
                        listVideo[listVideo.length - 1]
                            .closest(".list-lesson__item")
                            .insertAdjacentHTML("beforeend", buttonRatingHTML);
                        showRatingForm();
                        backToCourse();
                    }
                } else {
                    video.querySelector("source").src =
                        listVideo[index + 1].dataset.link;
                    video.dataset.id = listVideo[index + 1].dataset.id;
                    showListNote(
                        listVideo[index + 1].dataset.id,
                        listVideo[index + 1],
                        video
                    );
                    toTime();
                }
            });
        };
    };

    const showRatingForm = () => {
        const buttonRating = document.querySelector("[rating-course]");
        if (!buttonRating) return;
        buttonRating.onclick = () => {
            const elTop = buttonRating.closest("[course-el]");
            const elParent = elTop.parentElement;
            elTop.classList.add("hidden");
            elParent
                .querySelector("[rating-course-el]")
                .classList.remove("hidden");
        };
    };

    const backToCourse = () => {
        const backCourse = document.querySelector("[back-to-course]");
        if (!backCourse) return;
        backCourse.onclick = () => {
            const elTop = backCourse.closest("[rating-course-el]");
            const elParent = elTop.parentElement;
            elTop.classList.add("hidden");
            elParent.querySelector("[course-el]").classList.remove("hidden");
        };
    };

    const checkTime = () => {
        const video = document.querySelector("video");
        const note = document.querySelector("[name='note']");
        if (!video || !note) return;
        note.onkeydown = (e) => {
            if (e.which == 13) {
                e.preventDefault();
                XHR.send({
                    url: "them-ghi-chu",
                    method: "POST",
                    data: {
                        course_video_id: video.dataset.id,
                        time: video.currentTime,
                        content: note.value,
                    },
                }).then((res) => {
                    note.value = "";
                    XHR.send({
                        url: "lay-danh-sach-ghi-chu",
                        method: "POST",
                        data: {
                            course_video_id: video.dataset.id,
                        },
                    }).then((res) => {
                        document.querySelector("[list-note]").innerHTML =
                            res.html;
                        toTime();
                    });
                });
            }
        };
    };

    const toTime = () => {
        const video = document.querySelector("video");
        const listNote = document.querySelectorAll("[list-note] a");
        listNote.forEach((item) => {
            item.onclick = () => {
                video.currentTime = item.dataset.time;
                video.play();
            };
        });
    };

    return {
        init: (() => {
            load();
            checkTime();
            changeVideo();
            toTime();
            catchEventVideo();
            showRatingForm();
            backToCourse();
        })(),
    };
})();
