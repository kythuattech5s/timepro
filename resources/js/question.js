/*
 Cần những attribute sau để có thể chạy 
    list-data => danh sách item
    item => item trong danh sách
    rs-qaa-filter => cần lọc
    rs-qaa-load-more => load more
    rs-qaa-like => nút like
 */
class commentRS {
    constructor(selector, model, label, tableLike, fieldMain, withParam, view) {
        this.selectors = document.querySelectorAll(selector);
        if (this.selectors.length == 0) return;
        this.fieldMain = fieldMain;
        this.model = model;
        this.label = label;
        this.tableLike = tableLike;
        this.with = withParam;
        this.view = view;
        this.like();
        this.reply();
        this.filter();
        this.nextPage();
    }

    filter = () => {
        this.selectors.forEach((selector) => {
            const listFilters = selector.querySelectorAll("[rs-qaa-filter]");
            listFilters.forEach((filter) => {
                filter.onchange = () => {
                    const fomrData = new FormDataRS("", false);
                    const data = {
                        model: this.model,
                        label: this.label,
                        with: this.with,
                        field_main: this.fieldMain,
                        view: this.view,
                        ...fomrData.buildData(listFilters, "input"),
                    };

                    XHR.send({
                        url: "tai-cau-thoi",
                        method: "POST",
                        data: data,
                    }).then((res) => {
                        selector.querySelectorAll("[item]").forEach((item) => {
                            item.remove();
                        });
                        const listData = selector.querySelector("[list-data]");
                        const buttonNextPage =
                            listData.querySelector("[rs-qaa-load-more]");

                        if (buttonNextPage) {
                            buttonNextPage.remove();
                        }
                        listData.innerHTML = res.html;
                        this.like();
                        this.reply();
                        this.filter();
                        this.nextPage();
                    });
                };
            });
        });
    };

    like = () => {
        const likeButtons = document.querySelectorAll("[rs-qaa-like]");
        likeButtons.forEach((button) => {
            button.onclick = () => {
                const id = button.dataset.id;
                XHR.send({
                    url: "thich-cau-hoi",
                    method: "POST",
                    data: {
                        id: id,
                        model: this.model,
                        label: this.label,
                        table_like: this.tableLike,
                        field_main: this.fieldMain,
                    },
                }).then((res) => {
                    if (res.code == 200) {
                        !button.classList.contains("like") &&
                            button.classList.add("like");
                    } else if (res.code == 100) {
                        button.classList.contains("like") &&
                            button.classList.remove("like");
                    }
                    NOTIFICATION.showNotify(res.code, res.message);
                });
            };
        });
    };

    reply = () => {
        const replyAsk = document.querySelectorAll("[rs-qaa-reply]");
        replyAsk.forEach((button) => {
            button.onclick = () => {
                const parentElement = button.parentElement;
                const listChild = parentElement.querySelector(
                    "[rs-qaa-list-child]"
                );
                if (listChild.querySelector("form")) {
                    listChild.querySelector("form").remove();
                    return;
                }
                listChild.insertAdjacentHTML(
                    "beforeend",
                    `<form action="reply-cau-hoi" absolute clear class="form-validate" data-success="ASK_AND_ANSWER.showNotifyRemoveForm" method="POST">
                        <input type="hidden" name="_token" value="${document
                            .querySelector("meta[name='csrf-token']")
                            .getAttribute("content")}" />
                        <input  type="hidden" name="id" value="${
                            button.dataset.id
                        }" />
                        <input type="hidden" name="field_main" value="${
                            this.fieldMain
                        }" />
                        <input type="hidden" name="model" value="${this.model}">
                        <input type="hidden" name="label" value="${this.label}">
                        <div class="flex items-center p-3 rounded-md shadow-lg gap-2">
                            <textarea class="flex-1 outline-none p-2 h-[38px] bg-transparent resize-none rules="required" name="content" placeholder="Câu trả lời"></textarea>
                            <button type="submit" class="btn btn-red-gradien inline-flex items-center justify-center rounded bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-4 font-semibold text-white">Trả lời</button>
                        </div>
                    </form>`
                );
                listChild.querySelector("textarea").focus();
                VALIDATE_FORM.refresh();
            };
        });
    };

    nextPage = () => {
        this.selectors.forEach((selector) => {
            const nextPage = selector.querySelector("[rs-qaa-load-more]");
            if (!nextPage) return;
            nextPage.onclick = () => {
                const listFilters =
                    selector.querySelectorAll("[rs-qaa-filter]");
                const fomrData = new FormDataRS("", false);
                const data = {
                    model: this.model,
                    label: this.label,
                    field_main: this.fieldMain,
                    map_table: nextPage.dataset.table,
                    map_id: nextPage.dataset.id,
                    page: nextPage.dataset.nextPage,
                    with: this.with,
                    view: this.view,
                    ...fomrData.buildData(listFilters, "input"),
                };
                XHR.send({
                    url: "tai-cau-thoi",
                    method: "POST",
                    data: data,
                }).then((res) => {
                    nextPage.remove();
                    const listData = selector.querySelector("[list-data]");
                    listData.insertAdjacentHTML("beforeend", res.html);
                    this.like();
                    this.reply();
                });
            };
        });
    };
}
window["ASK_AND_ANSWER"] = (() => {
    return {
        _: (() => {
            new commentRS(
                "[ask-selector]",
                "\\App\\Models\\AskAndAnswer",
                "câu hỏi",
                "ask_and_answer_user",
                "ask_and_answer_id",
                "likes,asks",
                "courses.components.ask_item"
            );

            new commentRS(
                "[question-teacher-main]",
                "\\App\\Models\\QuestionTeacher",
                "câu hỏi cho giảng viên",
                "question_teacher_user",
                "question_teacher_id",
                "likes,questions",
                "components.question_item"
            );
        })(),
        showNotify: (res) => {
            NOTIFICATION.showNotify(res.code, res.message);
        },
        showNotifyRemoveForm: (res, data, form) => {
            NOTIFICATION.showNotify(res.code, res.message);
            form.remove();
        },
    };
})();
