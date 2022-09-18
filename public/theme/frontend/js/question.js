class RSQAA {
    constructor(table, tableName, tableLike) {
        this.table = table;
        this.tableName = tableName;
        this.tableLike = tableLike;
        this.like();
        this.reply();
        this.nextPage();
    }

    like = () => {
        const likeButtons = document.querySelectorAll("[like-ask]");
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
        const replyAsk = document.querySelectorAll("[rep-ask]");
        replyAsk.forEach((button) => {
            button.onclick = () => {
                const parentElement = button.parentElement;
                const listChild =
                    parentElement.querySelector("[list-ask-child]");
                listChild.insertAdjacentHTML(
                    "beforeend",
                    `<form action="reply-cau-hoi" class="form-validate" data-success="ASK_AND_ANSWER.showNotify" method="POST">
                        <input type="hidden" name="_token" value="${document
                            .querySelector("meta[name='csrf-token']")
                            .getAttribute("content")}" />
                        <input  type="hidden" name="ask_and_answer_id" value="${
                            button.dataset.id
                        }" />
                        <div>
                            <textarea class="" rules="required" name="content" placeholder="Câu trả lời"></textarea>
                            <button type="submit">Trả lời</button>
                        </div>
                    </form>`
                );
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
            like();
            repAsk();
        };
    };
}
var ASK_AND_ANSWER = (() => {
    return {
        init: (() => {
            const rqaas = document.querySelectorAll("[rs-qaa]");
            rqaas.forEach((item) => {
                new RSQAA(
                    item.dataset.name,
                    item.dataset.label,
                    item.dataset.like
                );
            });
        })(),
        showNotify: (res) => {
            NOTIFICATION.showNotify(res.code, res.message);
        },
    };
})();
