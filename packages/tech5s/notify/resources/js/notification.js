(() => {
    const notificationItems = document.getElementsByClassName("no-read");
    const counts = document.querySelectorAll("[count-not-read]");
    var readNotification = () => {
        let timeout = 0;
        Array.from(notificationItems).forEach((item) => {
            item.onclick = () => {
                if (!item.classList.contains("no-read")) {
                    window.location.href = item.dataset.href;
                    return;
                }
                clearTimeout(timeout);
                timeout = setTimeout(async () => {
                    const id = item.dataset.id;
                    const response = await XHR.send({
                        url: "danh-dau-da-doc-thong-bao",
                        method: "POST",
                        data: {
                            id: id,
                        },
                    });

                    if (response.code == 200) {
                        for (const itemEl of Array.from(
                            notificationItems
                        ).filter((item) => item.dataset.id === id)) {
                            if (itemEl.querySelector(".check")) {
                                itemEl
                                    .querySelector(".check")
                                    .classList.add("d-none");
                            }
                            await itemEl.classList.remove("no-read");
                        }

                        counts.forEach((item) => {
                            item.innerHTML = Number(item.innerText.trim()) - 1;
                        });
                    }
                    readNotification();
                }, 400);
            };
        });
    };

    var deleteNotification = () => {
        const deleteItems = document.querySelectorAll(
            ".account-notification-page .delete"
        );
        let timeout = 0;
        deleteItems.forEach((item) => {
            item.onclick = (e) => {
                e.preventDefault();
                e.stopPropagation();
                clearTimeout(timeout);
                timeout = setTimeout(async () => {
                    const id = item.dataset.id;
                    const response = await XHR.send({
                        url: "xoa-thong-bao",
                        method: "POST",
                        data: {
                            id: id,
                        },
                    });

                    if (response.code == 200) {
                        for (const itemEl of Array.from(
                            notificationItems
                        ).filter((item) => item.dataset.id === id)) {
                            if (itemEl.querySelector(".check")) {
                                itemEl
                                    .querySelector(".check")
                                    .classList.add("d-none");
                            }
                            await itemEl.classList.remove("no-read");
                        }

                        if (item.previousElementSibling !== null) {
                            counts.forEach((item) => {
                                item.innerHTML =
                                    Number(item.innerText.trim()) - 1;
                            });
                        }
                        item.closest(".item-notification").remove();
                    }
                    readNotification();
                }, 400);
            };
        });
    };

    var loadMore = () => {
        const loadMoreBtns = document.querySelectorAll(
            "[load-more-notification]"
        );
        loadMoreBtns.forEach((button) => {
            button.onclick = () => {
                XHR.send({
                    url: "/tai-them-thong-bao",
                    method: "POST",
                    data: {
                        page: button.dataset.page,
                        catalog: button.dataset.catalog,
                    },
                }).then((res) => {
                    button.previousElementSibling.insertAdjacentHTML(
                        "beforeend",
                        res.html
                    );
                    if (res.isLastPage) {
                        button.remove();
                    } else {
                        button.dataset.page = button.nextPage;
                    }
                });
                readNotification();
            };
        });
    };
    return {
        _: (() => {
            readNotification();
            deleteNotification();
            loadMore();
        })(),
    };
})();
