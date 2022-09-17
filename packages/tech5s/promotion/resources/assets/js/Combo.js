"use strict";
var COMBO = (function () {
    const TYPE_PERCENT = 1;
    const TYPE_MONEY = 2;
    const TYPE_SPECIAL = 3;

    function changeType() {
        const groupItem = document.querySelectorAll(".combo-group__item");
        const groupType = document.querySelectorAll(".combo-group-type");
        groupType.forEach((type, key) => {
            type.onclick = async () => {
                type.querySelector("input").checked = true;
                groupItem.forEach((group, keyGroup) => {
                    const groupForm = group.querySelector(".group-form");
                    const allInput = groupForm.querySelectorAll("input");
                    const noteType = group.querySelector(".note-type");
                    const noteError = group.querySelector(".note-error");
                    if (keyGroup === key) {
                        noteType ? noteType.removeAttribute("style") : "";
                        noteError ? noteError.removeAttribute("style") : "";
                        groupForm.removeAttribute("style");
                        allInput.forEach((input, keyInput) => {
                            input.disabled = false;
                            if (keyInput == 0) {
                                input.focus();
                            }
                        });
                    } else {
                        noteType ? (noteType.style.display = "none") : "";
                        noteError ? (noteError.style.display = "none") : "";
                        groupForm.style.display = "none";
                        allInput.forEach((input) => {
                            input.disabled = true;
                        });
                    }
                });
                VALIDATE_FORM.refresh();
                checkPriceProductForDiscount();
                COMBO._();
            };
        });
    }

    function changeQty() {
        const listQty = document.querySelectorAll('[name="qty"]');
        listQty.forEach(function (inpQty, key) {
            inpQty.oninput = async function () {
                await RS.inputNumber(inpQty, 1, 100000000);
                [...listQty]
                    .filter((input, keyInput) => keyInput != key)
                    .forEach((input) => (input.value = inpQty.value));
                pushContent(inpQty);
                checkPriceProductForDiscount();
            };
        });
    }

    function changeDiscount() {
        const listDiscount = document.querySelectorAll('[name="discount"]');
        listDiscount.forEach(function (intDiscount) {
            intDiscount.oninput = async function () {
                await RS.inputNumber(
                    intDiscount,
                    1,
                    intDiscount.hasAttribute("percent") ? 100 : 10000000000
                );
                pushContent(intDiscount);
                checkPriceProductForDiscount();
            };
        });
    }

    function pushContent(input) {
        let qty, discount, type, item, element, errorElement, string;

        item = input.closest(".combo-group__item");
        type = item.querySelector('[name="type"]');
        if (input.name == "qty") {
            qty = input;
            discount = item.querySelector('[name="discount"]');
        } else {
            discount = input;
            qty = item.querySelector('[name="qty"]');
        }

        if (qty.value == "" || discount.value == "") {
            item.querySelector(".note-type") &&
                item.querySelector(".note-type").remove();
            return;
        }

        element = document.createElement("p");
        element.className = "note-type";
        errorElement = document.createElement("p");
        errorElement.className = "note-error";
        switch (Number(type.value)) {
            case TYPE_PERCENT:
                if (Number(discount.value) > 70) {
                    string = "Mức khuyến mãi lớn hơn 70 % so với giá gốc";
                    if (item.querySelector(".note-type")) {
                        item.querySelector(".note-type").remove();
                    }
                    console.log("có");
                    if (item.querySelector(".note-error")) {
                        item.querySelector(".note-error").innerHTML = string;
                    } else {
                        errorElement.innerHTML = string;
                        item.append(errorElement);
                    }
                } else {
                    if (item.querySelector(".note-error")) {
                        item.querySelector(".note-error").remove();
                    }
                    string = `Giá cuối cùng = Giá hiện tại - ${discount.value} %`;
                    if (item.querySelector(".note-type")) {
                        item.querySelector(".note-type").innerHTML = string;
                    } else {
                        element.innerHTML = string;
                        item.append(element);
                    }
                }
                break;
            case TYPE_MONEY:
                string = `Giá cuối cùng = Giá hiện tại - ₫${RS.number_format(
                    Number(discount.value)
                )} `;
                if (item.querySelector(".note-type")) {
                    item.querySelector(".note-type").innerHTML = string;
                } else {
                    element.innerHTML = string;
                    item.append(element);
                }
                break;
            default:
                string = `Giá cuối cùng = ₫ ${RS.number_format(
                    Number(discount.value)
                )}`;
                if (item.querySelector(".note-type")) {
                    item.querySelector(".note-type").innerHTML = string;
                } else {
                    element.innerHTML = string;
                    item.append(element);
                }
                break;
        }
    }

    function checkPriceProductForDiscount() {
        let isPass = true;
        const type = document.querySelector('[name="type"]:checked');
        if (!type) return true;
        const item = type.closest(".combo-group__item");
        const discount = item.querySelector('[name="discount"]');
        const qty = item.querySelector('[name="qty"]');
        if (discount.value == "" || qty.value == "") return true;
        const listProduct = document.querySelectorAll(
            ".item-product table tbody tr"
        );
        if (listProduct.length == 0) return true;
        if (Number(type.value) == TYPE_MONEY) {
            listProduct.forEach((tr) => {
                const td = tr.querySelector("[data-price]");
                const act = tr.querySelector('[name="act"]');
                // Công thức tính phần trăm giảm tiền = Giá giảm / (giá sản phẩm * số lượng) * 100
                const percent =
                    (Number(discount.value) /
                        (Number(td.dataset.price) * Number(qty.value))) *
                    100;
                if (percent < 70 || !act.checked) {
                    if (td.querySelector(".note-error")) {
                        td.querySelector(".note-error").remove();
                    }
                } else {
                    const string = "Mức khuyến mãi lớn hơn 70 % so với giá gốc";
                    if (!td.querySelector(".note-error")) {
                        td.insertAdjacentHTML(
                            "beforeend",
                            `<p class="note-error">${string}</p>`
                        );
                    }
                    isPass = false;
                }
            });
        } else if (Number(type.value) == TYPE_SPECIAL) {
            listProduct.forEach((tr) => {
                const td = tr.querySelector("[data-price]");
                // Công thức tính phần trăm đặc biệt = 100% - giá cuối cùng / (giá sản phẩm * số lượng) * 100
                const percent =
                    100 -
                    (Number(discount.value) /
                        (Number(td.dataset.price) * Number(qty.value))) *
                        100;
                const act = tr.querySelector('[name="act"]');
                if (percent <= 70 || !act.checked) {
                    if (td.querySelector(".note-error")) {
                        td.querySelector(".note-error").remove();
                    }
                } else {
                    const string = "Mức khuyến mãi lớn hơn 70 % so với giá gốc";
                    if (!td.querySelector(".note-error")) {
                        td.insertAdjacentHTML(
                            "beforeend",
                            `<p class="note-error">${string}</p>`
                        );
                    }
                    isPass = false;
                }
            });
        } else {
            if (document.querySelector(".note-error")) {
                document.querySelectorAll(".note-error").forEach(item => item.remove());
            }
        }
        return isPass;
    }

    function changeLimit() {
        const limit = document.querySelector('[name="limit"]');
        if (!limit) return;
        limit.oninput = () => {
            RS.inputNumber(limit, 1);
        };
    }

    function changeAct() {
        const listAct = document.querySelectorAll('[name="act"]');
        listAct.forEach((input) => {
            input.onchange = () => {
                const tr = input.closest("tr");
                const act = input.checked ? 1 : 0;
                $.ajax({
                    url: "tp/combo/change-act",
                    method: "POST",
                    data: {
                        id: [tr.dataset.id],
                        act: act,
                    },
                }).done(function (res) {
                    if (res.code == 200) {
                        checkPriceProductForDiscount();
                    }
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
            const status = await ajaxChangeAct(true);
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
            const status = await ajaxChangeAct(false);
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

    function ajaxChangeAct(isOn) {
        const data = localStorage.getItem("PRODUCT_CHOOSES_COMBOS");
        return $.ajax({
            url: "tp/combo/change-act",
            method: "POST",
            data: {
                act: isOn ? 1 : 0,
                id: JSON.parse(data),
            },
        }).done((res) => {
            if (res.code == 200) {
                checkPriceProductForDiscount();
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
                $.ajax({
                    url: "tp/combo/remove-item",
                    method: "POST",
                    data: {
                        id: [buttonRemove.closest("tr").dataset.id],
                    },
                }).done((res) => {
                    if (res.code == 200) {
                        buttonRemove.closest("tr").remove();
                        checkLengthItem();
                    }
                });
            };
        });
    }

    function removeMultiple() {
        const buttonRemove = document.querySelector(
            ".action-item button.remove"
        );
        if (!buttonRemove) return;
        buttonRemove.onclick = function () {
            const data = localStorage.getItem("PRODUCT_CHOOSES_COMBOS");
            $.ajax({
                url: "tp/combo/remove-item",
                method: "POST",
                data: {
                    id: JSON.parse(data),
                },
            }).done((res) => {
                if (res.code == 200) {
                    const inputCheckeds =
                        document.querySelectorAll("[c-single]:checked");
                    inputCheckeds.forEach((input) => {
                        input.closest("tr").remove();
                    });
                    checkLengthItem();
                }
            });
        };
    }

    function checkLengthItem() {
        if (document.querySelectorAll("[c-single]").length == 0) {
            document.querySelector(
                ".item-product"
            ).innerHTML = `<button type="button" class="btn btn-blue" data-toggle="modal" data-target="#modalProduct" data-type="combos" data-action="create">
                Thêm sản phẩm
            </button>`;
        }
        M_CHECKBOX.refresh();
    }
    return {
        _: () => {
            if (!document.querySelector('button[data-type="combos"]')) return;
            changeType();
            changeQty();
            changeDiscount();
            changeLimit();
            changeAct();
            changeActMultiple();
            removeMultiple();
            removeItem();
        },
        checkPriceProductForDiscount: (a) => {
            return checkPriceProductForDiscount();
        },
    };
})();

window.addEventListener("DOMContentLoaded", function () {
    COMBO._();
});
