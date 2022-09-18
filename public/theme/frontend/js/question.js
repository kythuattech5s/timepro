var ASK_AND_ANSWER = (() => {
    const like = () => {
        const likeButtons = document.querySelectorAll("[like-ask]");
        likeButtons.forEach((button) => {
            button.onclick = () => {
                const id = button.dataset.id;
                XHR.send({
                    url: "thich-cau-hoi",
                    method: "POST",
                    data: {
                        ask_and_answer_id: id,
                    },
                }).then((res) => {
                    if (res.code == 200) {
                        !button.classList.contains("active") &&
                            button.classList.add("active");
                    } else if (res.code == 100) {
                        button.classList.contains("active") &&
                            button.classList.remove("active");
                    }
                    NOTIFICATION.showNotify(res.code, res.message);
                });
            };
        });
    };

    const repAsk = () => {
        const replyAsk = document.querySelectorAll("[rep-ask]");
    };
    return {
        init: (() => {
            like();
            repAsk();
        })(),
        showNotify: (res) => {
            NOTIFICATION.showNotify(res.code, res.message);
        },
    };
})();
