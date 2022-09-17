class PaginateList {
    constructor(
        url,
        method = "POST",
        arrayBuildData = ["data-page"],
        mainSelector,
        listItemSelector,
        arrayDataPush = {},
        arrayFnAfter = [],
        arrayFnBefore = []
    ) {
        this.url = url;
        this.method = method;
        this.arrayDataBuild = arrayBuildData;
        this.main = mainSelector;
        this.list = listItemSelector;
        this.arrayDataPush = arrayDataPush;
        this.fnAfter = arrayFnAfter;
        this.fnBefore = arrayFnBefore;
    }

    init() {
        const paginateAnchors = document.querySelectorAll(this.main);
        paginateAnchors.forEach((item) => {
            item.onclick = async (e) => await this.changeData(e, item);
        });
    }

    async callFunction(array, response = {}) {
        for await (const obFn of array) {
            const func = obFn.split(".");
            if (func.length > 1) {
                typeof window[func[0]] == "object" &&
                    typeof window[func[0]][func[1]] == "function" &&
                    (await window[func[0]][func[1]](response));
            } else {
                typeof window[func[0]] == "function" &&
                    (await window[func[0]](response));
            }
        }
    }

    async changeData(e, item) {
        e.preventDefault();
        const data = this.buildData(item);
        await this.callFunction(this.fnBefore);
        XHR.send({
            url: this.url ? this.url : item.href,
            method: this.method,
            data: data,
        }).then(async (res) => {
            const list = document.querySelector(this.list);
            list.innerHTML = await res.html;
            this.init();
            this.callFunction(this.fnAfter, res);
        });
    }

    buildData(item) {
        var data = {};
        this.arrayDataBuild.forEach((key) => {
            data[key] = item.getAttribute(`data-${key}`);
        });

        for (const [key, value] of Object.entries(this.arrayDataPush)) {
            data[key] = value;
        }
        return data;
    }
}

//  if (typeof PaginateList !== "undefined") {
// paginateItemDealChild = new PaginateList(
//             "shop/danh-sach-san-pham",
//             "POST",
//             ["promotion", "type", "page"],
//             "[paginate-deal-sub] a",
//             ".content-deal-sub",
//             { action: "add" },
//             ["DEAL._"],
//             ["DEAL.saveDataNow"]
//         );
// }
