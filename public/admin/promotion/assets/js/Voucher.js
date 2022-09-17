"use strict";
var VOUCHER = (() => {
    let typeDiscountOld;
    let typeSaleOld;
    let typeLimitOld;
    let typeUsedOld;
    let numberSatifyOld;
    let typeSaleCurrent;
    let typeDiscountCurrent;
    const VOUCHER_FOR_SHOP = 1;
    const VOUCHER_FOR_PRODUCT = 2;

    const VOUCHER_DISCOUNT_BY_MONEY = 1;
    const VOUCHER_DISCOUNT_BY_PERCENT = 2;

    const DICOUNT_PROMOTION = 1;
    const DICOUNT_REFUND_COIN = 2;

    const REFUND_LIMIT = 1;
    const REFUND_NO_LIMIT = 2;

    const TYPE_USED_NULL = 0;
    const TYPE_USED_MONEY = 1;
    const TYPE_USED_FOR_BUY_ORDER = 1;

    const voucherStorage = new Storage();

    function changeInputMax() {
        const refundLimitGroup = document.getElementById("refund-limit-group");
        if (!refundLimitGroup) return;
        const inputs = refundLimitGroup.querySelectorAll("input");
        const divChooseFooter = refundLimitGroup.querySelector(
            ".choose-coin__footer"
        );
        inputs.forEach(function (input) {
            if (input.name == "max_discount") {
                input.addEventListener("input", changeTotalCoin, false);
            } else {
                const ipMaxDiscount = divChooseFooter.querySelector("input");
                input.onchange = async function () {
                    setMaxDiscount(refundLimitGroup);
                    await ipMaxDiscount.addEventListener(
                        "input",
                        changeTotalCoin
                    );
                    VALIDATE_FORM.refresh();
                };
            }

            // Lấy loại giảm giá
            const inputRadios = Array.from(inputs).filter(
                (input) => input.type === "radio"
            );

            inputRadios.forEach(function (input, indexCurrent) {
                input.addEventListener("change", function () {
                    const inputMaxFake = divChooseFooter.querySelector("input");
                    const inputMax = divChooseFooter.querySelector(
                        "input[name='max_discount']"
                    );

                    voucherStorage.set(
                        `type_limit-${typeSaleCurrent}-${typeDiscountCurrent}`,
                        input.value
                    );
                    typeLimitOld = input.value;
                    voucherStorage.set(
                        `max_discount-${typeSaleOld}-${typeDiscountOld}`,
                        inputMax.value
                    );

                    const inputMaxIsLimit =
                        input.checked && input.value == REFUND_NO_LIMIT;
                    inputMaxIsLimit
                        ? divChooseFooter.setAttribute("style", "display:none")
                        : divChooseFooter.removeAttribute("style");
                    inputMax.setAttribute("disabled", inputMaxIsLimit);
                    inputMaxFake.setAttribute("disabled", inputMaxIsLimit);
                    VALIDATE_FORM.refresh();
                    setMaxDiscount(refundLimitGroup);
                    getDataMaxDiscount(inputMax);
                });
            });
        });
    }

    function onInputShowVoucherCode() {
        const inputVoucher = document.getElementById("voucher_code");
        if (inputVoucher) {
            inputVoucher.addEventListener("input", async () => {
                var valueInput = await RS.nonAccentVietnamese(
                    inputVoucher.value
                );
                valueInput = valueInput.toUpperCase();
                inputVoucher.value = valueInput;
                document.querySelector(".input_code").innerHTML = valueInput;
                document.querySelector(".voucher-code__suffix").innerHTML =
                    valueInput.length + " ký tự";
            });
        }
    }

    function changeTypeVoucher() {
        const typeVoucher = document.querySelectorAll(
            ".voucher-type__item input"
        );
        typeVoucher.forEach(function (inputType) {
            inputType.onchange = function () {
                const applyProduct = document.querySelector(".apply-product");
                const allCategory = document.querySelector(
                    ".voucher-category-all"
                );
                const applyCategory = document.querySelector(".apply-category");
                if (inputType.checked && inputType.value == VOUCHER_FOR_SHOP) {
                    applyCategory.classList.add("d-none");
                    applyCategory.innerHTML = "";
                    allCategory.classList.remove("d-none");
                    applyProduct
                        .querySelector(".voucher-for")
                        .classList.remove("d-none");
                    applyProduct
                        .querySelector("button")
                        .classList.add("d-none");
                    applyProduct
                        .querySelector(".item-product")
                        .classList.add("d-none");
                } else if (inputType.value == VOUCHER_FOR_PRODUCT) {
                    applyProduct
                        .querySelector(".voucher-for")
                        .classList.add("d-none");
                    applyProduct
                        .querySelector("button")
                        .classList.remove("d-none");
                    applyProduct
                        .querySelector(".item-product")
                        .classList.remove("d-none");

                    applyCategory.classList.remove("d-none");
                    allCategory.classList.add("d-none");
                    const data = localStorage.getItem(
                        applyCategory.getAttribute("m-checkbox").toUpperCase()
                    );
                    $.ajax({
                        url: "tp/voucher/show-list-category",
                        method: "GET",
                        data: {
                            promotion: "vouchers",
                            data: data,
                        },
                    }).done((res) => {
                        applyCategory.innerHTML = res.html;
                        M_CHECKBOX.refresh();
                        paginateCategoryList();
                        searchCategory();
                    });
                }
            };
        });
    }

    const paginateCategoryList = () => {
        const paginationEl = document.querySelectorAll(
            "[pagination-category-list] a"
        );
        paginationEl.forEach((el) => {
            el.onclick = (e) => {
                e.preventDefault();
                const promotion = el.dataset.promotion;
                const page = el.dataset.page;
                const data = localStorage.getItem(
                    el
                        .closest("[m-checkbox]")
                        .getAttribute("m-checkbox")
                        .toUpperCase()
                );

                const formData = {
                    page,
                    promotion,
                    data: data,
                    isShow: document.querySelector("#show-category-selected")
                        .checked
                        ? 1
                        : 0,
                };
                searchCategoryAjax(formData);
            };
        });
    };

    const searchCategoryAjax = (data) => {
        $.ajax({
            url: "tp/voucher/search-category",
            method: "POST",
            data: data,
        }).then((res) => {
            document.querySelector(".list-table").innerHTML = res.html;
            paginateCategoryList();
            M_CHECKBOX.refresh();
        });
    };

    const searchCategory = () => {
        const buttonSubmit = document.querySelector(".search-voucher-category");
        let timeout;
        if (!buttonSubmit) return;
        buttonSubmit.onclick = () => {
            clearTimeout(timeout);
            const q = buttonSubmit.previousElementSibling;
            const formData = {
                promotion: "vouchers",
                data: localStorage.getItem(
                    buttonSubmit
                        .closest("[m-checkbox]")
                        .getAttribute("m-checkbox")
                        .toUpperCase()
                ),
                isShow: document.querySelector("#show-category-selected")
                    .checked
                    ? 1
                    : 0,
                q: q.value,
            };
            timeout = setTimeout(() => {
                searchCategoryAjax(formData);
            }, 300);
        };
    };

    function getLimitType(refundLimitGroup) {
        const inputOfMaxDiscountEl = refundLimitGroup.querySelectorAll("input");
        const limitCurrent = Array.from(inputOfMaxDiscountEl).find(
            (input) => input.checked
        )
            ? Array.from(inputOfMaxDiscountEl).find((input) => input.checked)
                  .value
            : 1;
        return { inputOfMaxDiscountEl, limitCurrent };
    }

    function changeTypeDiscount() {
        const refundLimitGroup = document.getElementById("refund-limit-group");
        if (!refundLimitGroup) return;

        const { limitCurrent } = getLimitType(refundLimitGroup);
        typeLimitOld = limitCurrent;
        const inputMaxDiscount = refundLimitGroup.querySelector(
            'input[name="max_discount"]'
        );
        const typeDiscount = document.getElementById("type-discount");
        if (!typeDiscount) return;
        typeDiscount.onchange = function (e) {
            const divType = this.closest(".voucher-discount");
            const inputDiscount = divType.querySelector(
                'input[name="discount"]'
            );
            voucherStorage.set(
                `discount-${typeSaleOld}-${typeDiscountOld}`,
                inputDiscount.value !== ""
                    ? parseFloat(inputDiscount.value)
                    : ""
            );

            voucherStorage.set(
                `max_discount-${typeSaleOld}-${typeDiscountCurrent}`,
                inputMaxDiscount.value !== ""
                    ? parseFloat(inputMaxDiscount.value)
                    : ""
            );
            voucherStorage.set(
                `type_limit-${typeSaleOld}-${typeDiscountOld}`,
                typeLimitOld
            );
            typeDiscountCurrent = typeDiscount.value;
            typeDiscountOld = typeDiscountCurrent;
            voucherStorage.set(
                `type_discount-${typeSaleOld}`,
                typeDiscountCurrent
            );

            setMaxDiscount(
                refundLimitGroup,
                typeSaleOld == DICOUNT_PROMOTION ? true : false
            );
            setInputDiscount(
                inputDiscount,
                typeSaleOld == DICOUNT_PROMOTION ? true : false
            );

            getDataDiscount(inputDiscount);
            VALIDATE_FORM.refresh();
            changeTypeDiscount();
        };
    }

    function changeTypeSale() {
        const typeSales = document.querySelectorAll(
            ".voucher-saleBy__item input"
        );

        typeSales.forEach(function (typeSale) {
            const refundLimitGroup =
                document.getElementById("refund-limit-group");
            if (!refundLimitGroup) return;
            let typeDiscount = document.getElementById("type-discount");
            const inputDiscount = document.querySelector(
                'input[name="discount"]'
            );
            const inputMaxDiscount = refundLimitGroup.querySelector(
                'input[name="max_discount"]'
            );
            let { limitCurrent } = getLimitType(refundLimitGroup);
            typeLimitOld = limitCurrent;
            // lưu lại giá trị của loại lúc bắt đầu
            typeDiscountOld = typeDiscount.value;
            // Lưu dữ liệu cũ của typeVoucher
            buildOldData(typeSale, inputDiscount, inputMaxDiscount);

            //Thay đổi loại mã giảm giá
            typeSale.onchange = function () {
                typeSaleCurrent = typeSale.value;
                // Lưu lại giá trị trước khi thay đổi loại mã giảm giá
                saveDataTypeChange(inputDiscount, inputMaxDiscount);
                // Lấy lại loại giảm giá từ trong storage
                typeDiscountOld = voucherStorage.has(
                    `type_discount-${typeSale.value}`
                )
                    ? voucherStorage.get(`type_discount-${typeSale.value}`)
                    : document.getElementById("type-discount").value;

                let isPromotion = true;
                if (this.value == DICOUNT_PROMOTION) {
                    isPromotion = true;
                } else if (this.value == DICOUNT_REFUND_COIN) {
                    isPromotion = false;
                }

                setTypeDiscount(typeDiscount, isPromotion);

                typeDiscountCurrent =
                    document.getElementById("type-discount").value;
                typeLimitOld = voucherStorage.has(
                    `type_limit-${typeSale.value}-${typeDiscountCurrent}`
                )
                    ? voucherStorage.get(
                          `type_limit-${typeSale.value}-${typeDiscountCurrent}`
                      )
                    : 1;

                setMaxDiscount(refundLimitGroup, isPromotion);
                setInputDiscount(inputDiscount, isPromotion);

                typeSaleOld = typeSale.value;
                // Xử lý data inputDiscount

                getDataDiscount(inputDiscount);
                // Xử lý data inputMaxDiscount
                getDataMaxDiscount(inputMaxDiscount);
                VALIDATE_FORM.refresh();
                changeTypeDiscount();
            };
        });
    }

    function buildOldData(typeSale, inputDiscount, ipMaxDiscount) {
        typeDiscountCurrent == VOUCHER_DISCOUNT_BY_PERCENT
            ? voucherStorage.set(
                  `type_limit-${typeSale.value}-${VOUCHER_DISCOUNT_BY_PERCENT}`,
                  typeLimitOld
              )
            : voucherStorage.set(
                  `type_limit-${typeSale.value}-${VOUCHER_DISCOUNT_BY_PERCENT}`,
                  typeLimitOld
              );

        if (!typeSale.checked) return;
        typeSaleOld = typeSale.value;
        typeSaleCurrent = typeSaleOld;
        voucherStorage.set(
            `discount-${typeSaleOld}-${typeDiscountOld}`,
            inputDiscount.value !== "" ? parseFloat(inputDiscount.value) : ""
        );
        voucherStorage.set(
            `max_discount-${typeSaleOld}-${typeDiscountOld}`,
            ipMaxDiscount.value !== "" ? parseFloat(ipMaxDiscount.value) : ""
        );
        voucherStorage.set(`type_discount-${typeSaleOld}`, typeDiscountCurrent);
    }

    function getDataMaxDiscount(ipMaxDiscount) {
        const fakeInputMaxDiscount = ipMaxDiscount.previousElementSibling;
        const totalCoinAndMoney = ipMaxDiscount
            .closest(".choose-coin__footer")
            .querySelector(".total-coin");
        fakeInputMaxDiscount.value = "";
        ipMaxDiscount.value = "";
        totalCoinAndMoney.innerHTML = "";

        if (
            !voucherStorage.has(
                `max_discount-${typeSaleOld}-${typeDiscountOld}`
            )
        )
            return;

        const valueMaxDiscount = voucherStorage.get(
            `max_discount-${typeSaleOld}-${typeDiscountOld}`
        );
        const money = RS.number_format(valueMaxDiscount);

        fakeInputMaxDiscount.value = valueMaxDiscount != undefined ? money : "";
        ipMaxDiscount.value =
            valueMaxDiscount != undefined ? valueMaxDiscount : "";
        totalCoinAndMoney.innerHTML = money;
    }

    function getDataDiscount(inputDiscount) {
        const valueOld = voucherStorage.get(
            `discount-${typeSaleOld}-${typeDiscountOld}`
        );
        inputDiscount.previousElementSibling.value =
            valueOld != undefined ? RS.number_format(valueOld) : "";
        inputDiscount.value = valueOld != undefined ? valueOld : "";
    }

    function setMaxDiscount(refundLimitGroup, isPromotion = true) {
        const divChooseFooter = refundLimitGroup.querySelector(
            ".choose-coin__footer"
        );
        const prefixMoneyMaxValue =
            divChooseFooter.querySelector(".prefix-money");

        const divInputLimit = refundLimitGroup.querySelector(
            ".input-refund-limit"
        );
        const ipMaxDiscount = divInputLimit.querySelector(
            '[name="max_discount"]'
        );
        const prefixMaxDiscount = divInputLimit.querySelector(".limit-prefix");

        let { inputOfMaxDiscountEl } = getLimitType(refundLimitGroup);

        ipMaxDiscount.placeholder =
            typeDiscountCurrent == VOUCHER_DISCOUNT_BY_MONEY
                ? "Nhập số tiền tối đa"
                : "Nhập số COIN tối đa";
        prefixMaxDiscount.innerHTML = isPromotion ? "VND" : "COIN";
        prefixMoneyMaxValue.innerHTML = isPromotion ? "VND" : "COIN";

        const isLimit = voucherStorage.get(
            `type_limit-${typeSaleCurrent}-${typeDiscountCurrent}`
        );
        // Kiểm tra không giới hạn hoặc loại voucher bằng tiền thì ẩn ô nhập giới hạn

        typeDiscountCurrent == VOUCHER_DISCOUNT_BY_MONEY ||
        isLimit == REFUND_NO_LIMIT
            ? (divChooseFooter.style.display = "none")
            : divChooseFooter.removeAttribute("style");

        // Kiểm tra nếu loại voucher bằng tiền thì ẩn phần chọn giới hạn
        typeDiscountCurrent == VOUCHER_DISCOUNT_BY_MONEY
            ? (refundLimitGroup.style.display = "none")
            : refundLimitGroup.removeAttribute("style");

        // Kiểm tra nếu loại voucher là phần trăm thì mở chọn giới hạn
        Array.from(inputOfMaxDiscountEl)
            .filter((input) => input.type == "radio")
            .forEach((input) => {
                input.disabled =
                    typeDiscountCurrent != VOUCHER_DISCOUNT_BY_PERCENT;
                input.checked = input.value == isLimit;
            });

        Array.from(inputOfMaxDiscountEl)
            .filter((input) => input.type != "radio")
            .forEach((input) => {
                input.disabled =
                    typeDiscountCurrent != VOUCHER_DISCOUNT_BY_PERCENT &&
                    isLimit == REFUND_NO_LIMIT;
            });
    }

    function setInputDiscount(inputDiscount, isPromotion = true) {
        const prefixIpDiscount = inputDiscount.parentElement.querySelector(
            ".voucher-discount__prefix"
        );
        const inputDiscountFake = inputDiscount.previousElementSibling;
        isPromotion
            ? (prefixIpDiscount.innerHTML =
                  typeDiscountOld == VOUCHER_DISCOUNT_BY_MONEY
                      ? "VND"
                      : "% Giảm")
            : (prefixIpDiscount.innerHTML = "% Hoàn coin");
        inputDiscountFake.placeholder =
            typeDiscountOld == VOUCHER_DISCOUNT_BY_MONEY
                ? "Số tiền giảm"
                : "Nhập % giảm giá lớn hơn 1";
        inputDiscountFake.setAttribute(
            "rules",
            typeDiscountOld == VOUCHER_DISCOUNT_BY_MONEY
                ? "required"
                : "required||min:5||max:90"
        );
        return true;
    }

    function setTypeDiscount(typeDiscount, isPromotion = true) {
        typeDiscount.innerHTML = isPromotion
            ? ` <option value="${VOUCHER_DISCOUNT_BY_MONEY}"
                    ${
                        typeDiscountOld == VOUCHER_DISCOUNT_BY_MONEY
                            ? "selected"
                            : ""
                    }>
                        Theo số tiền
                </option>
                <option value="${VOUCHER_DISCOUNT_BY_PERCENT}"
                    ${
                        typeDiscountOld == VOUCHER_DISCOUNT_BY_PERCENT
                            ? "selected"
                            : ""
                    }>
                        Theo phần trăm
                </option>`
            : `<option value="${VOUCHER_DISCOUNT_BY_PERCENT}">Theo phần trăm</option>`;
    }

    function saveDataTypeChange(inputDiscount, inputMaxDiscount) {
        voucherStorage.set(
            `discount-${typeSaleOld}-${typeDiscountOld}`,
            inputDiscount.value !== "" ? parseFloat(inputDiscount.value) : ""
        );
        voucherStorage.set(
            `max_discount-${typeSaleOld}-${typeDiscountOld}`,
            inputMaxDiscount.value !== ""
                ? parseFloat(inputMaxDiscount.value)
                : ""
        );
        voucherStorage.set(`type_discount-${typeSaleOld}`, typeDiscountOld);
    }

    function changeTotalCoin() {
        document.querySelector(".total-coin").innerHTML = RS.number_format(
            this.value.replaceAll(".", "").replaceAll(",", "")
        );
    }

    function changeTypeUsed() {
        const inputRadios = document.querySelectorAll("[name='type_used']");
        const inputSatisfy = document.querySelector("[name='number_satisfy']");
        if (!inputSatisfy) return;
        typeUsedOld = Array.from(inputRadios).find(
            (input) => input.checked
        ).value;
        setDataOldSatisfy(typeUsedOld, inputSatisfy.value);
        inputRadios.forEach((item) => {
            item.onclick = function () {
                setDataOldSatisfy(typeUsedOld, inputSatisfy.value);
                typeUsedOld = item.value;
                inputSatisfy.disabled = item.value == TYPE_USED_NULL;
                inputSatisfy.value =
                    item.value == TYPE_USED_NULL
                        ? ""
                        : getDataOldSatisfy(typeUsedOld);
            };
        });
    }
    function getDataOldSatisfy(valueInput) {
        const value = voucherStorage.get(`type_used-${valueInput}`);
        return !value ? "" : value;
    }
    function setDataOldSatisfy(typeUsedOld, valueNumberSatisfy) {
        voucherStorage.set(`type_used-${typeUsedOld}`, valueNumberSatisfy);
    }
    function sendVoucher() {
        const button = document.querySelector(".send-voucher-for-user.all");
        if (!button) return;
        let timeout;
        button.onclick = function (e) {
            e.preventDefault();
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                XHR.send({
                    url: "tp/voucher/send",
                    method: "POST",
                    data: {
                        voucher_id: button.dataset.id,
                    },
                }).then((res) => {
                    AJAX_PROMOTION.createSuccess(res);
                });
            }, 400);
        };
    }

    function sendVoucherSelect() {
        const button = document.querySelector(".send-voucher-for-user.select");
        if (!button) return;
        if (
            localStorage.getItem(
                `SET_NOTIFICAITON_VOUCHER_${button.dataset.id}`
            )
        ) {
            localStorage.removeItem(
                `SET_NOTIFICAITON_VOUCHER_${button.dataset.id}`
            );
        }
        let timeout;
        button.onclick = function (e) {
            e.preventDefault();
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                XHR.send({
                    url: "tp/voucher/send",
                    method: "POST",
                    data: {
                        voucher_id: button.dataset.id,
                        id: JSON.parse(
                            localStorage.getItem(
                                `SET_NOTIFICAITON_VOUCHER_${button.dataset.id}`
                            )
                        ),
                    },
                }).then((res) => {
                    AJAX_PROMOTION.createSuccess(res);
                });
            }, 400);
        };
    }

    const paginationList = () => {
        const paginationEl = document.querySelectorAll(
            "[pagination-voucher-list] a"
        );
        paginationEl.forEach((el) => {
            el.onclick = (e) => {
                e.preventDefault();
                const promotion = el.dataset.promotion;
                const page = el.dataset.page;
                $.ajax({
                    url: "tp/voucher/load-product",
                    method: "POST",
                    data: {
                        page,
                        promotion,
                    },
                }).then((res) => {
                    el.closest(".list-product").innerHTML = res.html;
                    paginationList();
                    removeProductOfVoucher();
                });
            };
        });
    };

    function removeProductOfVoucher() {
        const buttonRemove = document.querySelectorAll(
            ".item-product .action button"
        );
        buttonRemove.forEach((button) => {
            button.onclick = function () {
                bootbox.confirm(
                    "Bạn có muốn xóa sản phẩm này!",
                    function (result) {
                        if (result) {
                            $.ajax({
                                url: "tp/voucher/remove-product",
                                method: "POST",
                                data: {
                                    id: button.closest("tr").dataset.id,
                                },
                            }).done((res) => {
                                if (res.count == 0) {
                                    document.querySelector(
                                        ".item-product"
                                    ).innerHTML = `<button type="button" class="btn bg-green-400 text-white" data-toggle="modal" data-target="#modalProduct" data-type="vouchers">
                        Thêm sản phẩm
                    </button>`;
                                } else {
                                    button.closest(".list-product").innerHTML =
                                        res.html;
                                    document.querySelector(
                                        ".count-product-chooses"
                                    ).innerHTML = res.count;
                                    paginationList();
                                    removeProductOfVoucher();
                                }
                            });
                        }
                    }
                );
            };
        });
    }

    const checkedShowCategory = () => {
        const inputChecked = document.querySelector("#show-category-selected");
        if (!inputChecked) return;
        let timeout;
        inputChecked.onchange = () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const data = {
                    promotion: "vouchers",
                    data: document.querySelector('[name="list_category"]')
                        .value,
                    isShow: inputChecked.checked ? 1 : 0,
                    q: document.querySelector(".category-filter input").value,
                };
                searchCategoryAjax(data);
            }, timeout);
            paginateCategoryList();
        };
    };

    return {
        _: () => {
            onInputShowVoucherCode();
            changeTypeVoucher();
            changeTypeDiscount();
            changeTypeSale();
            sendVoucher();
            changeInputMax();
            sendVoucherSelect();
            changeTypeUsed();
            paginationList();
            checkedShowCategory();
            removeProductOfVoucher();
            searchCategory();
            localStorage.setItem("CATEGORY_CHOOSE_VOUCHER", "");
            if (typeof M_CHECKBOX !== "undefined") {
                M_CHECKBOX.refresh();
            }
            paginateCategoryList();
        },
        paginationList: () => {
            paginationList();
        },
        removeProductOfVoucher: () => {
            removeProductOfVoucher();
        },
    };
})();

window.addEventListener("DOMContentLoaded", function () {
    VOUCHER._();
});
