class RSQAA {
    constructor(el, table, tableName, tableLike) {
        this.select = el;
        this.table = table;
        this.tableName = tableName;
        this.tableLike = tableLike;
        this.like();
        this.reply();
        this.nextPage();
    }

    like = () => {
        const likeButtons = this.select.querySelectorAll("[rs-qaa-reply]");
        console.log(likeButtons);
        likeButtons.forEach((button) => {
            button.onclick = () => {
                const id = button.dataset.id;
                XHR.send({
                    url: "thich-cau-hoi",
                    method: "POST",
                    data: {
                        ask_and_answer_id: id,
                        table: this.table,
                        table_name: this.tableName,
                        tableLike: this.tableLike,
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
        const replyAsk = this.select.querySelectorAll("[rs-qaa-reply]");
        replyAsk.forEach((button) => {
            button.onclick = () => {
                const parentElement = button.parentElement;
                const listChild = parentElement.querySelector(
                    "[rs-qaa-list-child]"
                );
                if (listChild.querySelector("form")) return;
                listChild.insertAdjacentHTML(
                    "beforeend",
                    `<form action="reply-cau-hoi" class="form-validate" data-success="ASK_AND_ANSWER.showNotifyRemoveForm" method="POST">
                        <input type="hidden" name="_token" value="${document
                            .querySelector("meta[name='csrf-token']")
                            .getAttribute("content")}" />
                        <input  type="hidden" name="ask_and_answer_id" value="${
                            button.dataset.id
                        }" />
                        <input type="hidden" name="table" value="${this.table}">
                        <input type="hidden" name="table_name" value="${
                            this.tableName
                        }">
                        <div>
                            <textarea class="" rules="required" name="content" placeholder="Câu trả lời"></textarea>
                            <button type="submit">Trả lời</button>
                        </div>
                    </form>`
                );
                listChild.querySelector("textarea").focus();
                VALIDATE_FORM.refresh();
            };
        });
    };

    nextPage = () => {
        const nextPage = document.querySelector("[ask-load-more]");
        if (!nextPage) return;
        nextPage.onclick = () => {
            XHR.send({
                url: "tai-them-cau-hoi",
                method: "GET",
                data: {
                    map_table: nextPage.dataset.table,
                    map_id: nextPage.dataset.id,
                    page: nextPage.dataset.nextPage,
                    table: this.table,
                    table_name: this.tableName,
                },
            }).then((res) => {
                nextPage.insertAdjacentHTML("beforebegin", res.html);
                if (res.isLastPage) {
                    nextPage.remove();
                }
            });
            this.like();
            this.repAsk();
        };
    };
}
var ASK_AND_ANSWER = (() => {
    return {
        init: (() => {
            const rqaas = document.querySelectorAll("[rs-qaa]");
            rqaas.forEach((item) => {
                new RSQAA(
                    item,
                    item.dataset.name,
                    item.dataset.label,
                    item.dataset.like
                );
            });
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
