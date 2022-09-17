var PRODUCT_FLASH_SALE = (() => {
    var searchItem = () => {
        const form = document.querySelector(".form-search-data");
        if (!form) return;

        const button = form.querySelector("button[type=submit]");
        button.onclick = () => {
            let data = new FormDataRS("search");
            data = data.getObjectData();
            XHR.send({
                url: "shop/flashsales/tim-kiem",
                data: data,
            }).then((res) => {
                const listItem = document.querySelector(".table-content");
                listItem.innerHTML = res.html;
                RS.removeSkeleton();
                paginateList();
            });
        };
    };

    var paginateList = () => {
        const anchors = document.querySelectorAll("[paginate-promotion] a");
        anchors.forEach((anchorEl) => {
            anchorEl.onclick = (e) => {
                e.preventDefault();
                XHR.send({
                    url: anchorEl.href,
                }).then((res) => {
                    mySupport.showNotify(res.code, res.message);
                    const list = document.querySelector(".table-content");
                    list.innerHTML = res.html;
                    paginateList();
                    RS.removeSkeleton();
                });
            };
        });
    };

    var confirmRegister = () => {
        const registerButton = document.querySelectorAll(
            ".register-flash-sale"
        );
        registerButton.forEach((button) => {
            button.onclick = (e) => {
                e.preventDefault();
                Swal.fire({
                    title: "Bạn muốn tham gia chương trình Flash sale này?",
                    showCancelButton: true,
                    confirmButtonText: "Tham gia",
                    cancelButtonText: `Không`,
                    confirmButtonColor: "#21ca61",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = button.href;
                    }
                });
            };
        });
    };

    const PERCENT = 1;
    const PRICE = 2;

    function changePercentProduct() {
        document.querySelectorAll('[name="price"]').forEach((input) => {
            input.oninput = async function (e) {
                RS.inputNumber(
                    input,
                    1,
                    Number(input.parentElement.dataset.price)
                );
                await dynamicPrice(e, PRICE);
                await validatePriceOnInput(input);
            };
        });
    }

    function changePriceProduct() {
        document.querySelectorAll('[name="percent"]').forEach((input) => {
            input.oninput = async function (e) {
                RS.inputNumber(input, 1, 100);
                await dynamicPrice(e, PERCENT);
                await validatePriceOnInput(
                    input.closest(".item-child").querySelector('[name="price"]')
                );
            };
        });
    }

    function changeQty() {
        document.querySelectorAll('[name="qty"]').forEach((input) => {
            input.oninput = function (e) {
                const item_child = input.closest(".item-child");
                const qty_current = item_child.querySelector(".qty-current");
                RS.inputNumber(input, 1, Number(qty_current.innerText));
            };
        });
    }

    async function validatePriceOnInput(inputPrice) {
        let isValid = false;
        const pricePrefix = Number(inputPrice.parentElement.dataset.price);
        if (Number(inputPrice.value) >= pricePrefix) {
            const errorElement = document.createElement("p");
            errorElement.className = "error";
            errorElement.innerHTML =
                "Giá khuyến mãi phải thấp hơn giá trị niêm yết của sản phẩm";
            errorElement.style.color = "red";
            if (
                inputPrice.parentElement.querySelectorAll("p.error").length == 0
            ) {
                inputPrice.parentElement.append(errorElement);
            }
            isValid = true;
            return isValid;
        }
        inputPrice.parentElement
            .querySelectorAll("p.error")
            .forEach((p) => p.remove());
    }

    function validateValue() {
        //Validate Price
        const items = document.querySelectorAll(
            "[c-parent-single]:checked:not([disabled])"
        );
        if (items.length > 0) {
            return validateCheck(items);
        } else {
            return validateNoCheck();
        }
    }

    function validateCheck(items) {
        var isValid = false;
        items.forEach(function (item) {
            const elementBig = item.closest("[c-check-item]");
            const itemChildChecked = elementBig.querySelectorAll(
                "[c-single]:checked:not([disabled])"
            );
            itemChildChecked.forEach((itemChild) => {
                itemChild = itemChild.closest(".item-child");
                const priceEls = itemChild.querySelectorAll(".price");
                priceEls.forEach((priceEl, key) => {
                    const errorElement = document.createElement("p");
                    const priceInp = priceEl.querySelector("input");
                    const pricePrefix = Number(priceEl.dataset.price);
                    if (Number(priceInp.value) >= pricePrefix) {
                        errorElement.className = "error";
                        errorElement.innerHTML =
                            "Giá khuyến mãi phải thấp hơn giá trị niêm yết của sản phẩm";
                        errorElement.style.color = "red";
                        if (
                            priceInp.parentElement.querySelectorAll("p.error")
                                .length == 0
                        ) {
                            priceInp.parentElement.append(errorElement);
                        }
                        isValid = true;
                        return isValid;
                    }
                    priceInp.parentElement
                        .querySelectorAll("p.error")
                        .forEach((p) => p.remove());
                });
            });
        });
        return isValid;
    }

    function validateNoCheck() {
        return validatePrice();
    }

    function validatePrice() {
        var isValid = false;
        const priceEls = document.querySelectorAll(".price");
        priceEls.forEach((priceEl, key) => {
            const errorElement = document.createElement("p");
            const priceInp = priceEl.querySelector("input");
            const pricePrefix = Number(priceEl.dataset.price);
            if (Number(priceInp.value) >= pricePrefix) {
                errorElement.className = "error";
                errorElement.innerHTML =
                    "Giá khuyến mãi phải thấp hơn giá trị niêm yết của sản phẩm";
                errorElement.style.color = "red";
                if (
                    priceInp.parentElement.querySelectorAll("p.error").length ==
                    0
                ) {
                    priceInp.parentElement.append(errorElement);
                }
                isValid = true;
                return isValid;
            }
            priceInp.parentElement
                .querySelectorAll("p.error")
                .forEach((p) => p.remove());
        });
        return isValid;
    }

    //Tự động cập nhật sau khi click
    async function dynamicPrice(event, mainChange = PERCENT) {
        const priceEls = document.querySelectorAll(".price");
        const percentEls = document.querySelectorAll(".percent");
        priceEls.forEach((priceEl, key) => {
            const percentInp = percentEls[key].querySelector("input");
            const priceInp = priceEl.querySelector("input");
            const pricePrefix = Number(priceEl.dataset.price);
            if (mainChange == PRICE) {
                percentInp.value = Math.round(
                    ((pricePrefix - Number(priceInp.value)) / pricePrefix) * 100
                );
            } else {
                priceInp.value =
                    pricePrefix -
                    Math.round((Number(percentInp.value) * pricePrefix) / 100);
            }
        });
    }

    function updateMultiple() {
        const buttonUpdateAll = document.querySelector(".update-flash-sale");
        if (buttonUpdateAll) {
            buttonUpdateAll.onclick = function (event) {
                event.preventDefault();
                const items = document.querySelectorAll(
                    "[c-parent-single]:checked:not([disabled])"
                );
                if (items.length == 0) {
                    updateAllNoSelect();
                } else {
                    updateAllHasSelect(items);
                }
            };
        }
    }

    function updateAllHasSelect(items) {
        items.forEach((item) => {
            const elementBig = item.closest("[c-check-item]");
            const itemChildChecked = elementBig.querySelectorAll(
                "[c-single]:checked:not([disabled])"
            );
            itemChildChecked.forEach((itemChild) => {
                itemChild = itemChild.closest(".item-child");
                const limitEls = elementBig.querySelectorAll(`[name="limit"]`);
                const percentEls =
                    itemChild.querySelectorAll('[name="percent"]');
                const qtyEls = itemChild.querySelectorAll('[name="qty"]');
                const qtyCurrentEls =
                    itemChild.querySelectorAll(".qty-current");
                updateNow(limitEls, percentEls, qtyEls, qtyCurrentEls);
            });
        });
    }

    function updateAllNoSelect() {
        const limitEls = document.querySelectorAll(`[name="limit"]`);
        const percentEls = document.querySelectorAll('[name="percent"]');
        const qtyEls = document.querySelectorAll('[name="qty"]');
        const qtyCurrentEls = document.querySelectorAll(".qty-current");
        updateNow(limitEls, percentEls, qtyEls, qtyCurrentEls);
    }

    function updateNow(limitEls, percentEls, qtyEls, qtyCurrentEls) {
        const dicount = document.querySelector('[name="discount"]');
        const qty = document.querySelector('[name="qty_discount"]');
        const limitDiscount = document.querySelector('[name="limit_discount"]');

        qtyEls.forEach((qtyEl, key) => {
            if (Number(qtyCurrentEls[key].innerText) < Number(qty.value)) {
                qtyEl.value = Number(qtyCurrentEls[key].innerText);
            } else {
                qtyEl.value =
                    qty.value !== ""
                        ? qty.value
                        : Number(qtyCurrentEls[key].innerText);
            }
        });
        percentEls.forEach(
            (percentEl) => (percentEl.value = dicount.value ?? 0)
        );
        limitEls.forEach(
            (limitEl) => (limitEl.value = limitDiscount.value ?? "")
        );
        percentEls[0].dispatchEvent(new Event("input"));
    }

    function changeAct() {
        const actEls = document.querySelectorAll('[name="act"]');
        actEls.forEach((actEl) => {
            actEl.addEventListener("change", async () => {
                actEl.value = actEl.checked ? 1 : 0;
                const itemChild = actEl.closest(".item-child");
                const itemBig = itemChild.closest("[c-check-item]");
                itemChild.querySelector("[c-single]").checked = true;
                itemBig.querySelector("[c-parent-single]").checked = true;
                // M_CHECKBOX.refresh();
                if (actEl.value == 1) {
                    const validate = validateValue();
                    if (validate) {
                        actEl.value == 0;
                        actEl.checked = false;
                        return false;
                    }
                }
                const inputs = itemChild.querySelectorAll("input[name]");
                let data = new FormDataRS();
                data = data.buildData(inputs, "input");
                const limit = itemBig.querySelector('[name="limit"]');
                if (limit.value !== "") {
                    data["limit"] = limit.value;
                }
                const res = await onOrOffProduct(data, actEl);
                if (res.code == 100) {
                    actEl.value = 0;
                    actEl.checked = false;
                }
                if (actEl.value == 1) {
                    inputs.forEach((input) => {
                        input.type !== "checkbox" &&
                            (input.disabled = input.name != "act");
                    });
                } else {
                    inputs.forEach((input) => {
                        input.disabled = false;
                    });
                }
            });
        });
    }

    function changeActOnMultiple() {
        const buttonOn = document.querySelector(".button-action .on");
        if (buttonOn) {
            buttonOn.onclick = function (event) {
                event.preventDefault();
                const validate = validateValue();
                if (validate) return;
                const items = document.querySelectorAll(
                    "[c-parent-single]:checked:not([disabled])"
                );
                if (items.length == 0) {
                    changeActAll("on");
                } else {
                    changeActItem(items, "on");
                }
            };
        }
    }

    function changeActOffMultiple() {
        const buttonOn = document.querySelector(".button-action .off");
        if (buttonOn) {
            buttonOn.onclick = function (event) {
                event.preventDefault();
                const validate = validateValue();
                if (validate) return;
                const items = document.querySelectorAll(
                    "[c-parent-single]:checked:not([disabled])"
                );
                if (items.length == 0) {
                    changeActAll("off");
                } else {
                    changeActItem(items, "off");
                }
            };
        }
    }

    function changeActAll(type = "on") {
        const actEls = document.querySelectorAll('[name="act"]');
        const items = document.querySelectorAll("[c-check-item]");

        actEls.forEach((actEl) => {
            const itemSingle = actEl.closest(".item-child");
            const qty = itemSingle.querySelector('[name="qty"]').value;
            const qtyCurrent = itemSingle.querySelector(".qty-current");
            if (actEl.checked && type == "off") {
                qtyCurrent.innerHTML =
                    parseInt(qtyCurrent.innerText) + parseInt(qty);
            }

            if (!actEl.checked && type == "on") {
                qtyCurrent.innerHTML =
                    parseInt(qtyCurrent.innerText) - parseInt(qty);
            }

            actEl.checked = type === "on" ? true : false;
            actEl.value = type === "on" ? 1 : 0;
        });

        const data = [];
        items.forEach((item, key) => {
            const itemChildChecked = item.querySelectorAll("[c-single]");
            itemChildChecked.forEach((itemChild) => {
                itemChild = itemChild.closest(".item-child");
                const inputs = itemChild.querySelectorAll("[name]");
                const act = itemChild.querySelector('[name="act"]');
                let dataForm = new FormDataRS("", true);
                const dataItem = dataForm.buildData(inputs, "input");
                const limit = item.querySelector('[name="limit"]');
                // const qty = item.querySelector('[name="qty"]').value;
                // const qtyCurrent = itemChild.querySelector(".qty-current");
                if (limit.value !== "") {
                    dataItem["limit"] = limit.value;
                }

                data.push(dataItem);
            });
        });

        const ajax = saveProductItem(data, type);

        ajax.then(function (res) {
            items.forEach((item, key) => {
                const itemChildChecked = item.querySelectorAll("[c-single]");
                itemChildChecked.forEach((itemChild) => {
                    itemChild = itemChild.closest(".item-child");
                    const inputs = itemChild.querySelectorAll("[name]");
                    const qty = itemSingle.querySelector('[name="qty"]').value;
                    const qtyCurrent = itemSingle.querySelector(".qty-current");

                    inputs.forEach(function (input) {
                        if (res.code === 100) {
                            type = "off";
                            input.type == "checkbox" && (input.checked = false);
                        }
                        if (type === "on") {
                            input.type !== "checkbox" &&
                                (input.disabled =
                                    input.name !== "act" ? true : false);
                        } else {
                            input.disabled = false;
                        }
                    });
                    const act = itemSingle.querySelector("[name='act']");
                    if (!act.checked && type == "on") {
                        qtyCurrent.innerHTML =
                            parseInt(qtyCurrent.innerText) + parseInt(qty);
                    }
                });
            });
        });
    }

    function changeActItem(items, type = "on") {
        const data = [];
        items.forEach((item) => {
            const elementBig = item.closest("[c-check-item]");
            const itemChildChecked = elementBig.querySelectorAll(
                "[c-single]:checked:not([disabled])"
            );
            itemChildChecked.forEach((itemChild) => {
                itemChild = itemChild.closest(".item-child");
                const qtyCurrent = itemChild.querySelector(".qty-current");
                const qty = itemChild.querySelector("[name='qty']").value;
                const inputAct = itemChild.querySelector('[name="act"]');
                if (inputAct.checked && type == "off") {
                    qtyCurrent.innerHTML =
                        parseInt(qtyCurrent.innerText) + parseInt(qty);
                }

                if (!inputAct.checked && type == "on") {
                    qtyCurrent.innerHTML =
                        parseInt(qtyCurrent.innerText) - parseInt(qty);
                }

                inputAct.checked = type === "on" ? true : false;
                inputAct.value = type === "on" ? 1 : 0;
                const inputs = itemChild.querySelectorAll("[name]");
                const formdata = new FormDataRS("", true);
                const dataItem = formdata.buildData(inputs, "input");
                const limit = elementBig.querySelector('[name="limit"]');
                if (limit.value !== "") {
                    dataItem["limit"] = limit.value;
                }
                data.push(dataItem);
            });
        });

        const ajax = saveProductItem(data, type);

        ajax.then((res) => {
            items.forEach((item) => {
                const elementBig = item.closest("[c-check-item]");
                const itemChildChecked = elementBig.querySelectorAll(
                    "[c-single]:checked:not([disabled])"
                );
                itemChildChecked.forEach((itemChild) => {
                    itemChild = itemChild.closest(".item-child");
                    const qtyCurrent = itemChild.querySelector(".qty-current");
                    const qty = itemChild.querySelector("[name='qty']").value;
                    const inputs = itemChild.querySelectorAll("[name]");
                    inputs.forEach(function (input) {
                        if (res.code === 100) {
                            type = "off";
                            input.type == "checkbox" && (input.checked = false);
                        }

                        if (type === "on") {
                            input.type !== "checkbox" &&
                                (input.disabled =
                                    input.name !== "act" ? true : false);
                        } else {
                            input.disabled = false;
                        }

                        if (
                            input.type == "checkbox" &&
                            !input.checked &&
                            type == "on"
                        ) {
                            qtyCurrent.innerHTML =
                                parseInt(qtyCurrent.innerText) + parseInt(qty);
                        }
                    });
                });
            });
        });

        M_CHECKBOX.refresh();
    }

    function removeMultiple() {
        const buttonRemove = document.querySelector(".button-action .remove");
        if (buttonRemove) {
            buttonRemove.onclick = (event) => {
                const arrayId = [];
                const parentId = [];
                event.preventDefault();
                const items = document.querySelectorAll(
                    "[c-parent-single]:checked:not([disabled])"
                );
                items.forEach(function (item) {
                    const bigItem = item.closest("[c-check-item]");
                    const itemChecked = bigItem.querySelectorAll(
                        "[c-single]:checked:not([disabled])"
                    );
                    itemChecked.forEach(function (checkedInp) {
                        arrayId.push(
                            JSON.stringify({
                                id: checkedInp.value,
                                parent: bigItem.dataset.id,
                            })
                        );
                    });

                    const lengthItem = bigItem.querySelectorAll("[c-single]");
                    if (lengthItem.length == itemChecked.length) {
                        parentId.push(bigItem.dataset.id);
                    }
                });

                let formData = {
                    id: arrayId,
                };

                if (parentId.length > 0) {
                    formData["parentId"] = parentId;
                }
                XHR.send({
                    url: "shop/flashsales/delete-item-product",
                    method: "POST",
                    data: formData,
                }).then(function (res) {
                    mySupport.showNotify(res.code, res.message);
                    items.forEach(function (item) {
                        const bigItem = item.closest("[c-check-item]");
                        const itemChecked = bigItem.querySelectorAll(
                            "[c-single]:checked:not([disabled])"
                        );
                        const lengthItem =
                            bigItem.querySelectorAll("[c-single]");
                        if (lengthItem.length == itemChecked.length) {
                            bigItem.remove();
                        } else {
                            itemChecked.forEach(function (checkedInp) {
                                checkedInp.closest(".item-child").remove();
                            });
                        }
                    });
                    const checkListItems =
                        document.querySelectorAll("[c-parent-single]");
                    if (checkListItems.length > 0) {
                        M_CHECKBOX.refresh();
                    } else {
                        document.querySelector(
                            ".item-product"
                        ).innerHTML = `<button type="button" class="btn btn-blue" data-toggle="modal" data-target="#modalProduct" data-type="flash_sales" data-action="create">
                        Thêm sản phẩm
                    </button>`;
                    }
                });
            };
        }
    }

    function saveProductItem(data, type) {
        return XHR.send({
            url: "shop/flashsales/change-data-multiple",
            method: "POST",
            data: {
                data: JSON.stringify(data),
                type: type,
                flash_sale_id: document.querySelector("[name=flash_sale_id]")
                    .value,
            },
        }).then((res) => {
            mySupport.showNotify(res.code, res.message);
            return res;
        });
    }

    async function onOrOffProduct(data, actEl) {
        data["flash_sale_id"] = document.querySelector(
            "[name=flash_sale_id]"
        ).value;

        return await XHR.send({
            url: "shop/flashsales/change-act",
            method: "POST",
            data: data,
        }).then((res) => {
            mySupport.showNotify(res.code, res.message);
            const qtyCurrent = actEl
                .closest(".item-child")
                .querySelector(".qty-current");
            qtyCurrent.innerHTML =
                data.act == 1
                    ? parseInt(qtyCurrent.innerText) - parseInt(data.qty)
                    : parseInt(qtyCurrent.innerText) + parseInt(data.qty);
            return res;
        });
    }

    function changeDiscount() {
        const discountInput = document.querySelector('[name="discount"]');
        if (discountInput) {
            discountInput.oninput = function (event) {
                RS.inputNumber(discountInput, 1, 100);
            };
        }
    }

    function deleteItem() {
        let timeout;
        const deleteItems = document.querySelectorAll(".delete-item");
        deleteItems.forEach((deleteButton) => {
            deleteButton.onclick = (event) => {
                event.preventDefault();
                const itemBig = deleteButton.closest("[c-check-item]");
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    XHR.send({
                        url: "shop/flashsales/delete-item-big",
                        method: "POST",
                        data: {
                            id: itemBig.dataset.id,
                            id_child: [
                                ...itemBig.querySelectorAll("[c-single]"),
                            ].map((item) => item.value),
                            flash_sale_id: document.querySelector(
                                "[name=flash_sale_id]"
                            ).value,
                        },
                    }).then((res) => {
                        mySupport.showNotify(res.code, res.message);
                        if (res.code == 200) {
                            itemBig.remove();
                            const checkListItems =
                                document.querySelectorAll("[c-parent-single]");
                            if (checkListItems.length > 0) {
                                M_CHECKBOX.refresh();
                            } else {
                                document.querySelector(
                                    ".box-product"
                                ).innerHTML = `Đây là chương trình:
                                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalProduct" data-promotion="flashsale" data-action="add">
                                    Thêm sản phẩm
                                </button>`;
                            }
                        }
                    });
                }, 300);
            };
        });
    }

    function getDataProductCurrent() {
        const data = [];
        const items = document.querySelectorAll("[c-check-item]");
        items.forEach((item, key) => {
            const itemChildChecked = item.querySelectorAll("[c-single]");
            itemChildChecked.forEach((itemChild) => {
                itemChild = itemChild.closest(".item-child");
                const inputs = itemChild.querySelectorAll("[name]");
                const dataForm = new FormDataRS("", true);
                const dataItem = dataForm.buildData(inputs, "input");
                const limit = item.querySelector('[name="limit"]');
                if (limit.value !== "") {
                    dataItem["limit"] = limit.value;
                }
                data.push(dataItem);
            });
        });

        return data;
    }
    async function saveDataAfterAdd() {
        const data = getDataProductCurrent();

        return await XHR.send({
            url: "shop/flashsales/change-data-multiple",
            method: "POST",
            data: {
                data: JSON.stringify(data),
                type: "saveData",
            },
        }).then(function (res) {
            if (res.code == 200) {
                return true;
            }
            return false;
        });
    }

    function saveProduct() {
        const button = document.querySelector(".form-footer button");
        if (!button) return;
        button.onclick = () => {
            const data = getDataProductCurrent();
            XHR.send({
                url: "shop/flashsales/save-product",
                method: "POST",
                data: {
                    data: JSON.stringify(data),
                    flash_sale_id: document.querySelector(
                        '[name="flash_sale_id"]'
                    ).value,
                },
            }).then(function (res) {
                mySupport.showNotify(res.code, res.message);
                if (res.code == 200) {
                    if (res.redirect_url) {
                        window.location.href = res.redirect_url;
                    }
                    return true;
                }
                return false;
            });
        };
    }

    function showProductLoad() {
        changePriceProduct();
        changePercentProduct();
        changeDiscount();
        updateMultiple();
        changeAct();
        changeQty();
        changeActOffMultiple();
        changeActOnMultiple();
        removeMultiple();
        deleteItem();
        saveProduct();
        if (typeof M_CHECKBOX !== "undefined") {
            M_CHECKBOX.refresh();
        }
    }

    return {
        _: () => {
            searchItem();
            RS.removeSkeleton();
            paginateList();
            confirmRegister();
            showProductLoad();
        },
        loadModuleFlashSale: function () {
            showProductLoad();
        },
        saveDataAfterAdd: async function () {
            return await saveDataAfterAdd();
        },
    };
})();

window.addEventListener("DOMContentLoaded", function () {
    PRODUCT_FLASH_SALE._();
});
