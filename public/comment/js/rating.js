class rating {
    constructor(selector) {
        this.selectors = document.querySelectorAll(selector);
        this.rating();
    }

    rating = () => {
        this.selectors.forEach((selector, id) => {
            selector.onchange = async (e) => {
                this.selectors.forEach((el, key) => {
                    if (key !== id) {
                        el.disabled = true;
                    }
                });
                const options = {
                    method: "POST",
                    url: "cmrs/source/danh-gia",
                    data: {
                        rate: selector.value,
                        map_id: selector.closest(".rating-now").dataset.id,
                        map_table:
                            selector.closest(".rating-now").dataset.table,
                    },
                };
                const resposne = await XHR.send(options);
                mySupport.showNotify(resposne.code, resposne.message);
            };
        });
    };
}

new rating('[name="rate"]');
