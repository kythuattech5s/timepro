"use strict";
var COMMENT = (function () {
    var _urlLoadmore,
        _urlLoadMoreChild,
        _hasFilter,
        _urlFilter,
        _urlLikeUnLike,
        _timeSkeleton;
    function setUrl(urls) {
        (_urlLoadmore = urls.loadmore),
            (_urlLoadMoreChild = urls.loadmoreChild),
            (_hasFilter = urls.hasFilter),
            (_urlFilter = urls.filter),
            (_urlLikeUnLike = urls.likeUnLike);
        _timeSkeleton = urls.timeSkeleton;
        COMMENT.init();
    }

    // REPLY COMMENT
    function repComment() {
        let timeout;
        const repComment = document.querySelectorAll(
            "[button-show-reply]:not(.hide)"
        );
        if (repComment.length > 0) {
            repComment.forEach(function (element, index) {
                element.onclick = function () {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        const form = element.parentElement;
                        const formGroup = form.querySelector(".group-form");
                        const replyForm = form.querySelector(".rep-comment");
                        if (element.hasAttribute("show")) {
                            formGroup.innerHTML = "";
                            formGroup.removeAttribute("style");
                            replyForm.classList.add("hidden");
                            element.removeAttribute("show");
                        } else {
                            replyForm.classList.remove("hidden");
                            const groupFormAnimate = formGroup.animate(
                                [{ opacity: 0 }],
                                {
                                    duration: 200,
                                    fill: "forwards",
                                }
                            );
                            groupFormAnimate.onfinish = function () {
                                element.setAttribute("show", "");
                                formGroup.innerHTML = "";
                                formGroup.removeAttribute("style");
                                groupFormAnimate.cancel();
                                showFormRepComment(
                                    formGroup,
                                    replyForm,
                                    element
                                );
                                hideRepComment();
                            };
                        }
                    }, 300);
                };
            });
        }
    }

    function hideRepComment() {
        let timeout;
        const buttonHides = document.querySelectorAll(
            ".rep-comment button.hide"
        );

        for (const button of buttonHides) {
            button.onclick = (e) => {
                e.preventDefault();
                timeout = setTimeout(() => {
                    const itemCommentAction =
                        e.target.closest(".comment-action");
                    button.previousElementSibling.setAttribute(
                        "type",
                        "button"
                    );
                    itemCommentAction.querySelector(".group-form").innerHTML =
                        "";
                }, 300);
            };
        }
    }

    function submitFormRepComment(formGroup, form, button) {
        const data = {
            isForm: true,
            form: form,
        };

        XHR.send(data)
            .then((response) => {
                if (response.code == 100) {
                    notification(response);
                    if (response.redirect_url) {
                        window.location.href = response.redirect_url;
                    }
                } else {
                    if (response.html) {
                        pushComment(formGroup, response);
                    }
                    notification(response);
                    formGroup.innerHTML = "";
                    form.classList.add("hidden");
                    button.removeAttribute("show");
                    return true;
                }
            })
            .then((response) => loadAll());
    }

    function showFormRepComment(formGroup, formReply, button) {
        var key = [];
        const element = formReply.querySelector("button[button-reply]");
        const textArea = document.createElement("textarea");
        textArea.name = "content";
        textArea.setAttribute("rules", "required");
        textArea.placeholder = element.dataset.placeholder;
        textArea.oninput = function () {
            textArea.style.border = "1px solid var(--color-star-evalue);";
            if (textArea.parentElement.querySelector("span")) {
                textArea.parentElement.querySelector("span").remove();
            }
        };
        formGroup.append(textArea);
        textArea.focus();
        element.onclick = () => {
            let isTrue = VALIDATE_FORM.checkForm(formGroup);
            if (isTrue) {
                submitFormRepComment(formGroup, formReply, button);
            }
        };

        textArea.addEventListener("keydown", function (e) {
            const arrayKey = [13, 16, 17];
            if (
                arrayKey.find((value) => {
                    return value == e.which;
                })
            ) {
                key.push(e.which);
            }
            if (key[0] == 13) {
                e.preventDefault();
                formGroup.nextElementSibling.click();
                key = [];
            }
            if (key[0] == 17 || key[0] == 16) {
                if (key[0] !== 16 && key[1] == 13 && key.length <= 2) {
                    textArea.value += "\n";
                    key = [];
                } else if (key[1] == 65) {
                    key = [];
                } else if (key.length >= 2) {
                    key = [];
                }
            } else {
                key = [];
            }
        });

        textArea.addEventListener("keyup", function (e) {
            key = [];
        });
    }

    function pushComment(formGroup, response) {
        let commentChild;
        if (
            !formGroup.closest(".comment-item").querySelector(".comment-childs")
        ) {
            commentChild = document.createElement("div");
            commentChild.className = "comment-childs";
            formGroup.closest(".comment-item").appendChild(commentChild);
        } else {
            commentChild = formGroup
                .closest(".comment-item")
                .querySelector(".comment-childs");
        }
        commentChild.insertAdjacentHTML("afterbegin", response.html);
    }

    // LOADMORE COMMENT CHILD
    function loadMoreChild() {
        let timeout;
        const buttonLoadMoreChilds = document.querySelectorAll(
            ".more-comment--child"
        );
        for (const btn of buttonLoadMoreChilds) {
            btn.onclick = function () {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    const parentId = btn.parentElement
                        .querySelector(".rep-comment")
                        .querySelector('[name="comment_id"]').value;
                    var main = btn.previousElementSibling;
                    var pagenumber = btn.getAttribute("page-current");
                    pagenumber++;
                    const options = {
                        url: _urlLoadMoreChild,
                        method: "POST",
                        data: {
                            comment_id: parentId,
                            page: pagenumber,
                        },
                    };
                    XHR.send(options)
                        .then(function (response) {
                            if (pagenumber == response.lastPage) {
                                btn.remove();
                            } else {
                                btn.setAttribute("page-current", pagenumber);
                            }
                            return response.html;
                        })
                        .then(function (response) {
                            main.insertAdjacentHTML("beforeend", response);
                            return true;
                        })
                        .then(function () {
                            loadMoreChild();
                            removeSkeleton();
                        });
                }, 300);
            };
        }
    }

    // LOADMORE COMMENT
    function loadMore() {
        const btnMore = document.querySelector(".more-comment");
        if (btnMore) {
            btnMore.onclick = function () {
                var main = btnMore.previousElementSibling;
                const map_table = btnMore.getAttribute("page-table");
                const map_id = btnMore.getAttribute("page-id");
                var pagenumber = btnMore.getAttribute("page-current");
                pagenumber++;
                const datas = {};
                datas.map_table = map_table;
                (datas.map_id = map_id), (datas.page = pagenumber);
                if (_hasFilter) {
                    var inputs = document.querySelectorAll(
                        ".comment-filter__lists input:checked"
                    );
                    if (inputs.length > 0) {
                        datas.filter = Array.from(inputs).map(
                            (input) => input.value
                        );
                    }
                    var sort = document.querySelector(".comment-sort select");
                    if (sort) {
                        datas.sort = sort.value;
                    }
                }
                const options = {
                    url: _urlLoadmore,
                    method: "POST",
                    data: datas,
                };
                XHR.send(options)
                    .then(function (response) {
                        if (pagenumber >= response.lastPage) {
                            btnMore.remove();
                        } else {
                            btnMore.setAttribute("page-current", pagenumber);
                        }
                        if (response.html) {
                            main.insertAdjacentHTML("beforeend", response.html);
                        }
                        return true;
                    })
                    .then(function (response) {
                        if (response) {
                            loadAll();
                        }
                    });
            };
        }
    }

    // NOTIFICATION
    function notification(response) {
        return NOTIFICATION.showNotify(response.code, response.message);
    }

    // FILLTER
    function processingButtonLoadMore(res, data) {
        const buttonLoadMore = document.querySelector("button.more-comment");
        if (res.lastPage == 1) {
            if (buttonLoadMore) {
                buttonLoadMore.remove();
            }
        } else {
            if (!buttonLoadMore) {
                const buttonLoadMore = document.createElement("button");
                buttonLoadMore.className = "more-comment";
                buttonLoadMore.setAttribute("page-table", data.table);
                buttonLoadMore.setAttribute("page-id", data.id);
                buttonLoadMore.setAttribute("page-current", 1);
                buttonLoadMore.innerText = "Xem thêm";
                document
                    .querySelector(".comment-box__list")
                    .insertAdjacentElement("afterend", buttonLoadMore);
            }
        }
    }

    function filter() {
        const filterLists = document.querySelector(".comment-filter__lists");
        const inputs = document.querySelectorAll("[filter='rating']");
        let timeChange;
        inputs.forEach(function (input, index) {
            input.onchange = function (e) {
                clearTimeout(timeChange);
                timeChange = setTimeout(() => {
                    let data = new FormDataRS();
                    data = data.buildData(inputs, "input");
                    data["map_table"] = filterLists.dataset.table;
                    data["map_id"] = filterLists.dataset.id;
                    filterXHR(data, filterLists);
                });
            };
        });
    }

    // Sort XHR
    function filterXHR(data, filterLists) {
        XHR.send({
            url: _urlFilter,
            method: "POST",
            data: data,
        })
            .then((res) => {
                processingButtonLoadMore(res, {
                    table: filterLists.dataset.table,
                    id: filterLists.dataset.id,
                });
                return res;
            })
            .then((res) => {
                receivedComment(
                    res,
                    {
                        map_table: filterLists.dataset.table,
                        map_table: filterLists.dataset.id,
                    },
                    false,
                    "list"
                );
            });
    }
    // LIKE
    function likeComment() {
        const buttonLikes = document.querySelectorAll("[like-comment]");
        let timeout;
        for (const button of buttonLikes) {
            button.onclick = function () {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    XHR.send({
                        method: "POST",
                        url: _urlLikeUnLike,
                        data: {
                            id: button.dataset.id,
                        },
                    }).then(function (res) {
                        notification(res);
                        if (res.code !== 100) {
                            button.classList.contains("like")
                                ? button.classList.remove("like")
                                : button.classList.add("like");
                        }
                    });
                }, 300);
            };
        }
    }

    // keyDownEvent
    function triggerKeyDown(elContent = undefined, elform = undefined) {
        if (!elform) {
            var elform = document.querySelector(".formComment");
        }
        if (!elform) return;
        if (!elContent) {
            var elContent = elform.querySelector("textarea");
        }
        var key = [];

        elContent.addEventListener("keydown", function (e) {
            const arrayKey = [13, 16, 17];
            if (
                arrayKey.find((value) => {
                    return value == e.which;
                })
            ) {
                key.push(e.which);
            }

            if (key[0] == 13) {
                e.preventDefault();
                elform.querySelector('button[type="submit"]').click();
                key = [];
            }

            if (key[0] == 17 || key[0] == 16) {
                if (key[0] !== 16 && key[1] == 13 && key.length <= 2) {
                    elContent.value += "\n";
                    key = [];
                } else if (key[1] == 65) {
                    key = [];
                } else if (key.length >= 2) {
                    key = [];
                }
            } else {
                key = [];
            }
        });

        elContent.addEventListener("keyup", function (e) {
            key = [];
        });
    }

    function focusTextarea(button) {
        const formComment = document.querySelector(".formComment");
        if (!formComment) return;
        formComment.querySelector("textarea").focus();
    }

    // CALLBACK
    function receivedComment(
        response,
        dataForm,
        hasNotification = true,
        insertType = "item"
    ) {
        if (hasNotification) {
            notification(response);
            if (typeof tinyMCE !== "undefined") {
                tinyMCE.activeEditor.setContent("");
            }
        }
        var main = document.querySelector(".comment-box__list");
        if (main.querySelectorAll(".comment-item").length == 9) {
            main.innerHTML = "";
        }
        // Kiểm tra có lastPage
        if (response.lastPage) {
            processingButtonLoadMore(response, {
                table: dataForm.map_table,
                id: dataForm.map_id,
            });
        }
        if (response.html) {
            if (insertType == "item") {
                main.insertAdjacentHTML(
                    main.hasAttribute("after") ? "beforeend" : "afterbegin",
                    response.html
                );

                if (!main.hasAttribute("after")) {
                    window.scrollTo({
                        top: main.offsetTop - 250,
                    });
                }
            } else {
                main.innerHTML = response.html;
            }
        }

        if (response.total_html) {
            const percent = document.querySelector(".box-percent-load");
            if (percent) {
                percent.innerHTML = response.total_html;
            }
        }

        if (response.count) {
            document
                .querySelectorAll("[comment-count]")
                .forEach((item) => (item.innerHTML = response.count));
        }

        if (response.plusCount) {
            document
                .querySelectorAll("[comment-count]")
                .forEach(
                    (item) => (item.innerHTML = Number(item.innerText) + 1)
                );
        }
        loadAll();
    }

    function loadAll() {
        repComment();
        loadMore();
        loadMoreChild();
        triggerKeyDown();
        removeSkeleton();
        likeComment();
        if (typeof refreshFsLightbox != "undefined") {
            refreshFsLightbox();
        }
        if (_hasFilter) {
            filter();
        }
    }

    function removeSkeleton() {
        document.querySelectorAll("[comment-skeleton]").forEach((item) => {
            setTimeout(() => {
                item.removeAttribute("comment-skeleton");
            }, 1000);
        });
    }

    return {
        init: function () {
            loadAll();
        },
        receivedComment: function (response, dataForm) {
            receivedComment(response, dataForm);
        },
        setUrl: function (urls) {
            setUrl(urls);
        },
        notification: function (res) {
            notification(res);
        },
        focusTextarea: function (button) {
            focusTextarea(button);
        },
    };
})();

var onlyRating = function () {
    var rating = function () {
        const els = document.getElementsByClassName('star[name="rate"]');
        els.forEach(function (el, id) {
            el.onchange = function (e) {
                el.pre;
                els.forEach(function (elo, key) {
                    if (key !== id) {
                        elo.disabled = true;
                    }
                });
                const options = {
                    method: "POST",
                    url: "danh-gia/",
                    data: {
                        rate: el.value,
                        map_id: el.closest(".rating-now").dataset.id,
                        map_table: el.closest(".rating-now").dataset.table,
                    },
                };

                XHR.send(options).then(function (res) {
                    COMMENT.notification(res);
                });
            };
        });
    };
    return {
        init: function () {
            rating();
        },
    };
};

var Tiny = (function () {
    const textarea = document.querySelector("#comment");
    if (typeof tinymce == "undefined") {
        return;
    }

    tinymce.init({
        selector: "#comment",
        menubar: false,
        statusbar: false,
        toolbar_location: "bottom",
        setup: function (editor) {
            editor.on("input", function (e) {
                tinyMCE.triggerSave();
                textarea.dispatchEvent(new Event("change"));
            }),
                editor.on("keyup", function (e) {
                    tinyMCE.triggerSave();
                    textarea.dispatchEvent(new Event("change"));
                });
        },
    });

    textarea.addEventListener("change", function () {
        if (textarea.value.trim == "") {
            tinyMCE.activeEditor.setContent("");
        }
    });
})();

window.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector(".comment-box")) {
        COMMENT.setUrl({
            loadmore: "cmrs/source/binh-luan-khac",
            loadmoreChild: "cmrs/source/binh-luan-be-khac",
            hasFilter: true,
            filter: "cmrs/source/loc-danh-gia",
            likeUnLike: "cmrs/source/thich-binh-luan",
            timeSkeleton: 1000,
        });
    }
});
