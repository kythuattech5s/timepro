"use strict";
var DEAL = (function () {
    const PERCENT = 1;
    const PRICE = 2;
    const TYPE_DEAL = 1;
    const TYPE_GIFT = 2;

    function progress() {
        const listGroup = document.querySelectorAll(".deal-group");
        listGroup.forEach(function (div, key) {
            let elProgress;
            if (
                (elProgress = div.querySelector(
                    ".deal-progress:not(.done) span"
                ))
            ) {
                elProgress.innerHTML = key + 1;
            }
        });
    }

    function changeType() {
        const listType = document.querySelectorAll(".deal-type__item");
        listType.forEach((type) => {
            type.onclick = async function () {
                const typeDeal = type.querySelector('[name="type"]').value;
                document
                    .querySelectorAll(`.deal-group__form[data-type]`)
                    .forEach((form) => {
                        if (form.dataset.type == typeDeal) {
                            form.querySelectorAll("input").forEach(
                                (input) => (input.disabled = false)
                            );
                            form.removeAttribute("style");
                        } else {
                            form.querySelectorAll("input").forEach(
                                (input) => (input.disabled = true)
                            );
                            form.style.display = "none";
                        }
                    });
                await DEAL._();
                await VALIDATE_FORM.refresh();
            };
        });
    }

    function changeQty() {
        const inpQty = document.querySelector('.manager-deal [name="qty"]');
        if (!inpQty) return;
        inpQty.addEventListener("input", function () {
            RS.inputNumber(inpQty, 1, 50);
        });
    }

    function changePrice() {
        const inpPrice = document.querySelector('.manager-deal [name="price"]');
        if (!inpPrice) return;
        inpPrice.addEventListener("input", function () {
            RS.inputNumber(inpPrice, 1, 1e10);
        });
    }

    function changeLimit() {
        const inpLimit = document.querySelector('.manager-deal [name="limit"]');
        if (!inpLimit) return;
        inpLimit.addEventListener("input", function () {
            RS.inputNumber(inpLimit, 1, 100);
        });
    }

    function saveDeal() {
        const buttonSaveDeal = document.querySelector("button.save-deal");
        if (!buttonSaveDeal) return;
        buttonSaveDeal.onclick = () => {
            const form = buttonSaveDeal.closest(".content");
            if (!VALIDATE_FORM.checkForm(form)) return;
            let data = new FormDataRS();
            data = data.buildData(form.querySelectorAll("[name]"), "input");
            data["action"] = buttonSaveDeal.dataset.action;
            XHR.send({
                url: "tp/deal/create",
                method: "POST",
                data: data,
            }).then((res) => {
                AJAX_PROMOTION.alert(res);
                if (res.code == 200) {
                    form.innerHTML = res.html;
                    const dealProgress = form.previousElementSibling;
                    pushProgress(dealProgress);
                    const itemProductMain =
                        document.querySelector(".item-product-main");
                    const groupItemProductMain =
                        itemProductMain.closest(".deal-group");
                    const dealProgressProductMain =
                        groupItemProductMain.querySelector(".deal-progress");
                    if (dealProgressProductMain.classList.contains("done")) {
                        dealProgressProductMain.classList.remove("done");
                        dealProgressProductMain.querySelector(
                            "span"
                        ).innerHTML = 2;
                    }
                    dealProgressProductMain.classList.add("active");

                    if (res.action !== "copy") {
                        itemProductMain.innerHTML = `
                        <h4>Sản phẩm chính</h4>
                        <p>Số lượng tối đa mỗi khách được mua là 100 sản phẩm chính trong cùng 1 chương trình Mua Kèm Deal Sốc</p>
                        <button type="button" class="btn bg-blue-400 text-white" data-toggle="modal" data-target="#modalProduct" data-type="deals" data-action="${itemProductMain.dataset.action}" data-type-product="main">
                        Thêm sản phẩm</button>`;

                        if (res.type == TYPE_GIFT) {
                            const itemProductSub =
                                document.querySelector(".item-product-sub");
                            itemProductSub.innerHTML = `
                                <h4>Quà tặng</h4>
                                <p>Người mua chỉ có thể nhận quà tặng một lần duy nhất trên một đơn hàng.</p>
                            `;
                        }
                    } else {
                        itemProductMain.innerHTML = res.html_product_main;
                        saveProductMain();
                    }
                    editDeal();
                }
            });
        };
    }

    function editDeal() {
        const editDeal = document.querySelector(".edit-deal");
        if (!editDeal) return;
        editDeal.onclick = function (e) {
            e.preventDefault();
            const id = editDeal.dataset.id;
            XHR.send({
                url: `tp/deal/edit-deal/${id}`,
                data: {
                    action: editDeal.dataset.action,
                },
            }).then((res) => {
                const dealGroupCurrent = editDeal.closest(".deal-group");
                const dealGroupNext = dealGroupCurrent.nextElementSibling;
                const dealProgressCurrent =
                    dealGroupCurrent.querySelector(".deal-progress");
                const dealProgressNext =
                    dealGroupNext.querySelector(".deal-progress");
                dealProgressCurrent.classList.remove("done");
                dealProgressCurrent.classList.add("active");
                dealProgressCurrent.querySelector("span").innerHTML = 1;
                dealProgressNext.querySelector("span").innerHTML = 2;
                dealProgressNext.classList.remove("active");
                dealGroupCurrent.querySelector(".content").innerHTML = res.html;
                dealGroupNext.querySelector(".item-product-main").innerHTML =
                    "";
                DEAL._();
                VALIDATE_FORM.refresh();
                saveEditDeal();
            });
        };
    }

    function saveEditDeal() {
        const buttonSaveEdit = document.querySelector(".save-edit-deal");
        if (!buttonSaveEdit) return;
        buttonSaveEdit.onclick = function () {
            const form = buttonSaveEdit.closest(".content");
            if (!VALIDATE_FORM.checkForm(form)) return;
            let data = new FormDataRS();
            data = data.buildData(form.querySelectorAll("[name]"), "input");
            data["action"] = buttonSaveEdit.dataset.action;
            XHR.send({
                url: "tp/deal/save-edit-deal",
                method: "POST",
                data: data,
            }).then((res) => {
                AJAX_PROMOTION.alert(res);
                if (res.code == 200) {
                    form.innerHTML = res.html;
                    const dealProgress = form.previousElementSibling;
                    pushProgress(dealProgress);
                    const itemProductMain =
                        document.querySelector(".item-product-main");
                    const groupItemProductMain =
                        itemProductMain.closest(".deal-group");
                    const dealProgressProductMain =
                        groupItemProductMain.querySelector(".deal-progress");
                    dealProgressProductMain.classList.add("active");
                    itemProductMain.innerHTML = `
                    <h4>Sản phẩm chính</h4>
                    <p>Số lượng tối đa mỗi khách được mua là 100 sản phẩm chính trong cùng 1 chương trình Mua Kèm Deal Sốc</p>
                    <button type="button" class="btn bg-blue-400 text-white" data-toggle="modal" data-target="#modalProduct" data-type="deals" data-action="${itemProductMain.dataset.action}" data-type-product="main">
                    Thêm sản phẩm</button>`;
                    editDeal();
                }
            });
        };
    }

    function changeAct() {
        const listAct = document.querySelectorAll(
            '.item-product-main [name="act"]'
        );
        listAct.forEach((input) => {
            input.onchange = () => {
                input.value = input.checked ? 1 : 0;
                $.ajax({
                    url: "tp/deal/change-act",
                    method: "POST",
                    data: {
                        id: [input.closest("tr").dataset.id],
                        act: input.value,
                        type: input.dataset.typeProduct,
                    },
                });
            };
        });
    }

    function changeActSub() {
        const listAct = document.querySelectorAll(
            '.item-product-sub [name="act"]'
        );
        listAct.forEach((input) => {
            input.onchange = () => {
                input.value = input.checked ? 1 : 0;
                const itemChild = input.closest(".item-child");
                if (input.value == 1) {
                    const validate = validateValue([itemChild]);
                    if (validate) {
                        input.value == 0;
                        input.checked = false;
                        return false;
                    }
                }
                const inputs = itemChild.querySelectorAll("[name]");
                let data = new FormDataRS("", true);
                data = data.buildData(inputs, "input");
                $.ajax({
                    url: "tp/deal/change-act-sub",
                    method: "POST",
                    data: {
                        data: JSON.stringify([data]),
                        type: input.dataset.typeProduct,
                    },
                });
            };
        });
    }

    function changeActMultiple() {
        const buttonOn = document.querySelector(".action-item button.on");
        const buttonOff = document.querySelector(".action-item button.off");
        if (!buttonOn) return;
        if (!buttonOff) return;
        buttonOn.onclick = async () => {
            const status = await ajaxChangeAct(
                true,
                buttonOn.dataset.typeProduct
            );
            if (status) {
                const inputCheckeds =
                    document.querySelectorAll("[c-single]:checked");
                inputCheckeds.forEach((input) => {
                    input
                        .closest("tr")
                        .querySelector('[name="act"]').checked = true;
                });
            }
        };

        buttonOff.onclick = async () => {
            const status = await ajaxChangeAct(
                false,
                buttonOff.dataset.typeProduct
            );
            if (status) {
                const inputCheckeds =
                    document.querySelectorAll("[c-single]:checked");
                inputCheckeds.forEach((input) => {
                    input
                        .closest("tr")
                        .querySelector('[name="act"]').checked = false;
                });
            }
        };
    }

    function ajaxChangeAct(isOn, typeProduct) {
        const data = localStorage.getItem(
            `PRODUCT_CHOOSES_PRODUCT_${typeProduct.toUpperCase()}`
        );
        return $.ajax({
            url: "tp/deal/change-act",
            method: "POST",
            data: {
                act: isOn ? 1 : 0,
                id: JSON.parse(data),
                type: typeProduct,
            },
        }).done((res) => {
            if (res.code == 200) {
                return true;
            }
            return false;
        });
    }

    function removeItem() {
        const listRemoveButton =
            document.querySelectorAll("button.remove-item");
        listRemoveButton.forEach((buttonRemove) => {
            buttonRemove.onclick = () => {
                removeTypeDeal(buttonRemove.dataset.typeProduct, buttonRemove);
            };
        });
    }

    function removeTypeDeal(type, button) {
        let id = [];
        if (type == "main") {
            id.push(button.closest("tr").dataset.id);
        } else {
            const item = button.closest(".item");
            id.push(item.dataset.id);
            item.querySelectorAll('.item-child input[name="id"]').forEach(
                (input) => {
                    if (!id.includes(input.value)) {
                        id.push(input.value);
                    }
                }
            );
        }
        $.ajax({
            url: "tp/deal/remove-item",
            method: "POST",
            data: {
                id: id,
                type: type,
            },
        }).done((res) => {
            if (res.code == 200) {
                if (type == "main") {
                    button.closest("tr").remove();
                } else {
                    button.closest(".item").remove();
                }
                checkLengthItem(
                    `.item-product-${button.dataset.typeProduct}`,
                    button.dataset.typeProduct
                );
            }
        });
    }

    function removeMultiple() {
        const buttonRemove = document.querySelector(
            ".action-item button.remove"
        );
        if (!buttonRemove) return;
        buttonRemove.onclick = function () {
            const data = localStorage.getItem(
                `PRODUCT_CHOOSES_PRODUCT_${buttonRemove.dataset.typeProduct.toUpperCase()}`
            );
            $.ajax({
                url: "tp/deal/remove-item",
                method: "POST",
                data: {
                    id: JSON.parse(data),
                    type: buttonRemove.dataset.typeProduct,
                    action: buttonRemove.dataset.action,
                },
            }).done((res) => {
                if (res.code == 200) {
                    const inputCheckeds = document.querySelectorAll(
                        `.item-product-${buttonRemove.dataset.typeProduct} [c-single]:checked`
                    );
                    inputCheckeds.forEach((input) => {
                        input.closest("tr").remove();
                    });
                    checkLengthItem(
                        `.item-product-${buttonRemove.dataset.typeProduct}`,
                        buttonRemove.dataset.typeProduct,
                        buttonRemove.dataset.action
                    );
                }
            });
        };
    }

    function checkLengthItem(selector, type, action) {
        if (document.querySelectorAll(`${selector} [c-single]`).length == 0) {
            if (type == "main") {
                document.querySelector(selector).innerHTML = `
                <h4>Sản phẩm chính</h4>
                <p>Số lượng tối đa mỗi khách được mua là 100 sản phẩm chính trong cùng 1 chương trình Mua Kèm Deal Sốc</p><button type="button" class="btn bg-blue-400 text-white" data-toggle="modal" data-target="#modalProduct" data-type="deals" data-action="${action}" data-type-product="${type}">
                    Thêm sản phẩm
                </button>`;
            } else {
                document.querySelector(selector).innerHTML = `
                <h4>Sản phẩm mua kèm</h4>
                    <p>Người mua có thể tận hưởng các sản phẩm mua kèm giá khuyến mãi khi họ mua bất
                        kỳ sản phẩm chính nào.
                    </p><button type="button" class="btn bg-blue-400 text-white" data-toggle="modal" data-target="#modalProduct" data-type="deals" data-action="${action}" data-type-product="${type}">
                    Thêm sản phẩm
                </button>
                `;
            }
            if (type == "main") {
                const editDeal = document.querySelector(".edit-deal");
                if (editDeal.classList.contains("no-edit")) {
                    editDeal.classList.remove("no-edit");
                }
            } else {
                const editProductMain =
                    document.querySelector(".edit-product-main");
                if (editProductMain.classList.contains("no-edit")) {
                    editProductMain.classList.remove("no-edit");
                }
            }
        }
        M_CHECKBOX.refresh();
    }

    function saveProductMain() {
        let timeout;
        const saveProduct = document.querySelector(".save-product-main");
        if (!saveProduct) return;
        saveProduct.onclick = () => {
            clearTimeout(timeout);
            timeout = XHR.send({
                url: "tp/deal/save-product-main",
                method: "POST",
                data: {
                    action: saveProduct.dataset.action,
                    promotion: saveProduct.dataset.type,
                },
            }).then((response) => {
                if (response.code == 200) {
                    const dealGroup = saveProduct.closest(".deal-group");
                    dealGroup.querySelector(".item-product-main").innerHTML =
                        response.html;
                    const dealProgress =
                        dealGroup.querySelector(".deal-progress");
                    pushProgress(dealProgress);
                    //Xử lý product sub

                    const itemProductSub =
                        document.querySelector(".item-product-sub");
                    const groupItemProductSub =
                        itemProductSub.closest(".deal-group");
                    const dealProgressProductSub =
                        groupItemProductSub.querySelector(".deal-progress");
                    dealProgressProductSub.classList.add("active");
                    if (response.action == "copy") {
                        itemProductSub.innerHTML = response.html_product_sub;
                        if (dealProgressProductSub.classList.contains("done")) {
                            dealProgressProductSub.classList.remove("done");
                            dealProgressProductSub.querySelector(
                                "span"
                            ).innerHTML = 3;
                        }
                        saveDataProductSub();
                    } else {
                        if (response.type == TYPE_DEAL) {
                            itemProductSub.innerHTML = `<h4>Sản phẩm mua kèm</h4>
                            <p>Người mua có thể tận hưởng các sản phẩm mua kèm giá khuyến mãi khi họ mua bất
                                kỳ sản phẩm chính nào.
                            </p><button type="button" class="btn bg-blue-400 text-white" data-toggle="modal" data-target="#modalProduct" data-type="deals" data-action="${itemProductSub.dataset.action}" data-type-product="sub">
                            Thêm sản phẩm
                            </button>`;
                        } else {
                            itemProductSub.innerHTML = `<h4>Quà tặng</h4>
                            <p>Người mua chỉ có thể nhận quà tặng một lần duy nhất trên một đơn hàng.</p><button type="button" class="btn bg-blue-400 text-white" data-toggle="modal" data-target="#modalProduct" data-type="deals" data-action="${itemProductSub.dataset.action}" data-type-product="sub">
                            Thêm sản phẩm
                            </button>`;
                        }
                    }
                    editProductMain();
                }
            });
        };
    }

    function pushProgress(dealProgress) {
        dealProgress.classList.remove("active");
        dealProgress.classList.add("done");
        dealProgress.querySelector(
            "span"
        ).innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M4.03033009,7.46966991 C3.73743687,7.1767767 3.26256313,7.1767767 2.96966991,7.46966991 C2.6767767,7.76256313 2.6767767,8.23743687 2.96966991,8.53033009 L6.32804531,11.8887055 C6.62093853,12.1815987 7.09581226,12.1815987 7.38870548,11.8887055 L13.2506629,6.02674809 C13.5435561,5.73385487 13.5435561,5.25898114 13.2506629,4.96608792 C12.9577697,4.6731947 12.4828959,4.6731947 12.1900027,4.96608792 L6.8583754,10.2977152 L4.03033009,7.46966991 Z"></path></svg>`;
    }

    function editProductMain() {
        const buttonEditProductMain =
            document.querySelector(".edit-product-main");
        if (!buttonEditProductMain) return;

        buttonEditProductMain.onclick = function (e) {
            e.preventDefault();
            XHR.send({
                url: "/tp/deal/edit-product-main",
                data: {
                    action: buttonEditProductMain.dataset.action,
                    promotion: buttonEditProductMain.dataset.type,
                    type: buttonEditProductMain.dataset.typeProduct,
                },
            }).then((res) => {
                const dealGroup = buttonEditProductMain.closest(".deal-group");
                const itemProductMain =
                    buttonEditProductMain.closest(".item-product-main");
                itemProductMain.innerHTML = res.html;
                const dealProgress = dealGroup.querySelector(".deal-progress");
                dealProgress.querySelector("span").innerHTML = 2;
                dealProgress.classList.remove("done");
                dealProgress.classList.add("active");
                const itemProductSub =
                    document.querySelector(".item-product-sub");
                const groupItemProductSub =
                    itemProductSub.closest(".deal-group");
                const dealProgressProductSub =
                    groupItemProductSub.querySelector(".deal-progress");
                dealProgressProductSub.classList.remove("active");
                itemProductSub.innerHTML = `<h4>Sản phẩm mua kèm</h4>
                <p>Người mua có thể tận hưởng các sản phẩm mua kèm giá khuyến mãi khi họ mua bất
                    kỳ sản phẩm chính nào.
                </p>`;
                DEAL._();
            });
        };
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

    function updateMultiple() {
        const buttonUpdateAll = document.querySelector(".update-deal");
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
                const percentEls =
                    itemChild.querySelectorAll('[name="percent"]');
                const limitEls = itemChild.querySelectorAll('[name="limit"]');
                const qtyCurrentEls =
                    itemChild.querySelectorAll(".qty-current");
                updateNow(percentEls, limitEls, qtyCurrentEls);
            });
        });
    }

    function updateAllNoSelect() {
        const percentEls = document.querySelectorAll(
            '.item-product-sub [name="percent"]'
        );
        const limitEls = document.querySelectorAll(
            '.item-product-sub [name="limit"]'
        );
        const qtyCurrentEls = document.querySelectorAll(
            ".item-product-sub .qty-current"
        );
        updateNow(percentEls, limitEls, qtyCurrentEls);
    }

    function updateNow(percentEls, limitEls, qtyCurrentEls) {
        const dicount = document.querySelector('[name="discount"]');
        const limitDiscount = document.querySelector('[name="limit_discount"]');

        limitEls.forEach((limitEl, key) => {
            if (
                Number(qtyCurrentEls[key].innerText) <
                Number(limitDiscount.value)
            ) {
                limitEl.value = Number(qtyCurrentEls[key].innerText);
            } else {
                limitEl.value =
                    limitDiscount.value !== ""
                        ? limitDiscount.value
                        : Number(qtyCurrentEls[key].innerText);
            }
        });
        percentEls.forEach(
            (percentEl) => (percentEl.value = dicount.value ?? 0)
        );
        percentEls[0].dispatchEvent(new Event("input"));
    }

    function changeActOnMultiple() {
        const buttonOn = document.querySelector(".button-action .on");
        if (buttonOn) {
            buttonOn.onclick = function (event) {
                event.preventDefault();
                const validate = validateValue();
                if (validate) return;
                const items = document.querySelectorAll(
                    ".item-product-sub [c-parent-single]:checked:not([disabled])"
                );
                changeActItem(items, "on");
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
                changeActItem(items, "off");
            };
        }
    }

    function removeMultipleSub() {
        const buttonRemove = document.querySelector(
            ".item-product-sub .button-action button.remove"
        );
        if (!buttonRemove) return;
        buttonRemove.onclick = function () {
            const items = document.querySelectorAll(
                ".item-product-sub [c-parent-single]:checked:not([disabled])"
            );
            let id = [];
            items.forEach((item) => {
                const itemProduct = item.closest(".item");
                id.push(itemProduct.dataset.id);
                itemProduct
                    .querySelectorAll('.item-child input[name="id"]')
                    .forEach((input) => {
                        if (!id.includes(input.value)) {
                            id.push(input.value);
                        }
                    });
            });

            XHR.send({
                url: "tp/deal/remove-item",
                method: "POST",
                data: {
                    id: id,
                    type: buttonRemove.dataset.typeProduct,
                },
            }).then((res) => {
                if (res.code == 200) {
                    items.forEach((item) => {
                        const itemProduct = item.closest(".item");
                        itemProduct.remove();
                    });
                    M_CHECKBOX.refresh();
                    checkLengthItem(
                        `.item-product-${buttonRemove.dataset.typeProduct}`,
                        buttonRemove.dataset.typeProduct
                    );
                }
            });
        };
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
                const inputAct = itemChild.querySelector('[name="act"]');
                inputAct.checked = type === "on" ? true : false;
                inputAct.value = type === "on" ? 1 : 0;
                const inputs = itemChild.querySelectorAll("[name]");
                let formData = new FormDataRS("", true);
                const dataItem = formData.buildData(inputs, "input");
                data.push(dataItem);
            });
        });
        saveProductItem(data, type);
        M_CHECKBOX.refresh();
    }

    function validateValue(items = null) {
        //Validate Price
        if (items == null) {
            items = [];
            const itemParent = document.querySelectorAll(
                "[c-parent-single]:checked:not([disabled])"
            );
            itemParent.forEach((item) =>
                items.push(
                    ...Array.from(
                        item.closest(".item").querySelectorAll(".item-child")
                    )
                )
            );
        }
        if (items.length > 0) {
            return validateCheck(items);
        } else {
            return validateNoCheck();
        }
    }

    function saveProductItem(data, type) {
        return $.ajax({
            url: "tp/deal/change-act-sub",
            method: "POST",
            data: {
                data: JSON.stringify(data),
                type: type,
            },
        });
    }

    function validateCheck(items) {
        var isValid = false;
        items.forEach(function (itemChild) {
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

    function saveDataProductSub() {
        const buttonSaveProduct = document.querySelector(".save-product-sub");
        if (!buttonSaveProduct) return;
        buttonSaveProduct.onclick = function () {
            const itemProductSub = document.querySelector(".item-product-sub");
            const data = [];
            const items = itemProductSub.querySelectorAll("[c-check-item]");
            if (items.length == 0) return;
            items.forEach((item, key) => {
                const itemChildChecked = item.querySelectorAll("[c-single]");
                itemChildChecked.forEach((itemChild) => {
                    itemChild = itemChild.closest(".item-child");
                    const inputs = itemChild.querySelectorAll("[name]");
                    let formData = new FormDataRS("", true);
                    const dataItem = formData.buildData(inputs, "input");
                    data.push(dataItem);
                });
            });
            return $.ajax({
                url: "tp/deal/save-product-sub",
                method: "POST",
                data: {
                    data: JSON.stringify(data),
                    type_save: "save",
                    type: buttonSaveProduct.dataset.typeProduct,
                    promotion: buttonSaveProduct.dataset.type,
                    action: buttonSaveProduct.dataset.action,
                },
            }).done(function (res) {
                if (res.code == 200) {
                    const dealGroup = buttonSaveProduct.closest(".deal-group");
                    dealGroup.querySelector(".item-product-sub").innerHTML =
                        res.html;
                    const dealProgress =
                        dealGroup.querySelector(".deal-progress");
                    pushProgress(dealProgress);
                    console.log(
                        document.querySelector(
                            '.form-footer button[type="submit"]'
                        )
                    );
                    document.querySelector(
                        '.form-footer button[type="submit"]'
                    ).disabled = false;
                    //Xử lý product sub
                    editProductSub();
                }
            });
        };
    }

    function editProductSub() {
        let timeout;
        const buttonEditProductSub =
            document.querySelector(".edit-product-sub");
        if (!buttonEditProductSub) return;

        buttonEditProductSub.onclick = () => {
            timeout = setTimeout(() => {
                document.querySelector(
                    '.form-footer button[type="submit"]'
                ).disabled = true;

                XHR.send({
                    url: `tp/deal/edit-product-sub`,
                    data: {
                        type: buttonEditProductSub.dataset.typeProduct,
                        promotion: buttonEditProductSub.dataset.type,
                        action: buttonEditProductSub.dataset.action,
                    },
                }).then((res) => {
                    if (res.code == 200) {
                        const dealGroup =
                            buttonEditProductSub.closest(".deal-group");
                        dealGroup.querySelector(".item-product-sub").innerHTML =
                            res.html;
                        const dealProgress =
                            dealGroup.querySelector(".deal-progress");
                        dealProgress.querySelector("span").innerHTML = 3;
                        dealProgress.classList.remove("done");
                        dealProgress.classList.add("active");
                        DEAL._();
                        M_CHECKBOX.refresh();
                    }
                });
            }, 300);
        };
    }

    return {
        _: async () => {
            changeActOnMultiple();
            changeActOffMultiple();
            editProductSub();
            changeType();
            progress();
            changeActSub();
            changeQty();
            changePrice();
            updateMultiple();
            editDeal();
            changeLimit();
            changePriceProduct();
            saveDeal();
            changeAct();
            changeActMultiple();
            removeItem();
            editProductMain();
            removeMultiple();
            saveProductMain();
            removeMultipleSub();
            saveDataProductSub();
        },
    };
})();

window.addEventListener("DOMContentLoaded", function () {
    DEAL._();
});