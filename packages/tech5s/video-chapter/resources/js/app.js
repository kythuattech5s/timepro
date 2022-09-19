import Helper from "../../../../roniejisa/scripts/assets/js/Helper.js";
(() => {
    const load = () => {
        const video = document.querySelector("video");
        if (!video) return;
        video.onplay = handleEventVideo;
        video.onpause = handleEventVideo;
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
        });
    };

    const changeVideo = () => {
        const video = document.querySelector("video");
        if (!video) return;
        const listVideo = document.querySelectorAll("[data-link]");
        listVideo.forEach((item) => {
            item.onclick = () => {
                if (video.dataset.id == item.dataset.id) return;
                showListNote(item.dataset.id, item, video);
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
            video.querySelector("source").src = item.dataset.link;
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
                if (index >= listVideo.length - 1) {
                    video.pause();
                    const buttonRatingHTML = `<button rating-course class="inline-flex flex-1 items-center justify-center bg-[#ebebeb] p-3 font-semibold text-[#888] transition-all duration-300">Đánh giá khóa học</button>`;
                    if (
                        !item
                            .closest(".list-lesson__item")
                            .parentEleemnt.querySelector(
                                "button[rating-course]"
                            )
                    ) {
                        item.closest(".list-lesson__item").insertAdjacentHTML(
                            "afterend",
                            buttonRatingHTML
                        );
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
