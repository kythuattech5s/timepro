var BASE = (() => {
    var scroll = () => {
        const element = document.querySelector(".frag-footer");
        if (!element) return;
        const elementFooter = document.querySelector(".form-footer");
        const io = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    elementFooter.classList.add("sticky");
                    return;
                }
                elementFooter.classList.remove("sticky");
            });
        });
        io.observe(element);
    };

    var format = () => {
        const inputEls = document.querySelectorAll("[inf]");
        inputEls.forEach((inputEl) => {
            inputEl.addEventListener("input", async function (e) {
                const valueInput = inputEl.value
                    .replaceAll(",", "")
                    .replaceAll(".", "")
                    .replaceAll(/[a-zA-Z]/g, "");
                const val = valueInput === "" ? "" : parseFloat(valueInput);
                const inputCurrent = inputEl.nextElementSibling;
                inputEl.value = await RS.number_format(val);
                inputCurrent.value = val;
                inputCurrent.dispatchEvent(new Event("input"));
            });
        });
    };

    function searchShop() {
        const inputSearch = document.querySelector(".search-shop");
        if (!inputSearch) return;
        let timeout;
        inputSearch.oninput = () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                $.ajax({
                    url: "tp/marketing/search-shop",
                    method: "POST",
                    data: {
                        q: inputSearch.value,
                    },
                }).done((res) => {
                    inputSearch.nextElementSibling.innerHTML = res.html;
                });
            }, 300);
        };
    }

    function onchangeShopId() {
        const selectShop = document.querySelector('[name="shop_id"]');
        const chooseProduct = document.querySelector(
            '[data-target="#modalProduct"]'
        );
        if (!selectShop) return;
        if (!chooseProduct) return;
        
        selectShop.onchange = () => {
            if (selectShop.value !== "") {
                chooseProduct.disabled = false;
            } else {
                chooseProduct.disabled = true;
            }
        };
    }

    return {
        _: () => {
            scroll();
            format();
            searchShop();
            onchangeShopId();
        },
        searchShop:()=>{
            searchShop();
        }
    };
})();

var MODALPRODUCT = (() => {
    function showModal() {
        $("#modalProduct").on("shown.bs.modal", function (e) {
            const _this = $(this);
            if (e.relatedTarget.dataset.typeProduct == "sub") {
                saveDataCurrent();
            }

            var dataConfig = {
                promotion: e.relatedTarget.dataset.type,
                action: e.relatedTarget.dataset.action,
                type: e.relatedTarget.dataset.typeProduct,
            };

            const shop_id = document.querySelector('[name="shop_id"]');
            if (shop_id) {
                dataConfig["shop_id"] = shop_id.value;
            }

            if (document.querySelector('[name="start_at"]')) {
                dataConfig["start_at"] =
                    document.querySelector('[name="start_at"]').value;
            }

            if (document.querySelector('[name="expired_at"]')) {
                dataConfig["expired_at"] = document.querySelector(
                    '[name="expired_at"]'
                ).value;
            }
            $.ajax({
                url: "tp/marketing/show-product",
                data: dataConfig,
            }).done(function (res) {
                _this.find(".modal-content").html(res.html);
                M_CHECKBOX.clear();
                M_CHECKBOX.refresh();
                VALIDATE_FORM.refresh();
                applyProductForPromotion();
                paginateCategory();
                showAndHideProductSelected();
                formSearch();
            });
        });
    }

    function paginateCategory() {
        const paginate = document.querySelectorAll("[paginate-modal-product]");
        paginate.forEach((pagination) => {
            const paginateList = pagination.getElementsByTagName("a");
            Array.from(paginateList).forEach((anchorEl) => {
                anchorEl.onclick = function (e) {
                    e.preventDefault();
                    const getAttribute = new FormDataRS("filter");
                    const data = getAttribute.getObjectData();
                    data["page"] = anchorEl.dataset.page;
                    data["product_chooses"] = localStorage.getItem(
                        anchorEl
                            .closest("[m-checkbox]")
                            .getAttribute("m-checkbox")
                            .toUpperCase()
                    );
                    if (document.querySelector('[name="start_at"]')) {
                        data["start_at"] =
                            document.querySelector('[name="start_at"]').value;
                    }
                    if (document.querySelector('[name="expired_at"]')) {
                        data["expired_at"] = document.querySelector(
                            '[name="expired_at"]'
                        ).value;
                    }
                    searchProduct(data);
                };
            });
        });
    }

    function formSearch() {
        const formButton = document.querySelector('.form-search-item [type="button"]');

        if (!formButton) return;
        let timeout;
        formButton.onclick = () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                let data = new FormDataRS("filter", false);
                data = data.getObjectData();
                const inputChecked = document.querySelector("#product_has_promotion");
                data["product_chooses"] = localStorage.getItem(
                    inputChecked
                        .closest(".modal-content")
                        .getAttribute("m-checkbox")
                        .toUpperCase()
                );
                searchProduct(data);
            }, 400);
        };
    }

    function saveDataCurrent(type) {
        const itemProductSub = document.querySelector(".item-product-sub");
        const data = [];
        const items = itemProductSub.querySelectorAll("[c-check-item]");
        if (items.length == 0) return;
        items.forEach((item, key) => {
            const itemChildChecked = item.querySelectorAll("[c-single]");
            itemChildChecked.forEach((itemChild) => {
                itemChild = itemChild.closest(".item-child");
                const inputs = itemChild.querySelectorAll("[name]");
                const dataItem = XHR.buildData(inputs, true);
                data.push(dataItem);
            });
        });

        return $.ajax({
            url: "sys-promotion/deals/save-product-sub",
            method: "POST",
            data: {
                data: JSON.stringify(data),
            },
        }).done(function (res) {
            if (res.code == 200) {
                return true;
            }
            return false;
        });
    }

    function applyProductForPromotion() {
        const buttonChooseProduct = document.querySelector(
            ".choose-product-button"
        );
        if (buttonChooseProduct) {
            buttonChooseProduct.onclick = async function () {
                const promotion = buttonChooseProduct.dataset.type;
                const action = buttonChooseProduct.dataset.action;
                const type = buttonChooseProduct.dataset.typeProduct;
                var isPass = true;
                switch (promotion) {
                    case "vouchers":
                        isPass = await applyProductForVoucher(
                            promotion,
                            action
                        );
                        break;
                    case "combos":
                        isPass = await applyProductForCombo(promotion, action);
                        break;
                    case "deals":
                        isPass = await applyProductForDeal(
                            promotion,
                            action,
                            type
                        );
                        break;
                    case "flash_sales":
                        isPass = await applyProductForFlashSale(
                            promotion,
                            action
                        );
                        break;
                }
            };
        }
    }

    async function applyProductForVoucher(promotion) {
        const productChoose = document.querySelector(
            'textarea[name="product_choose"]'
        );
        if (productChoose !== null) {
            $.ajax({
                url: "tp/marketing/choose-product-for-promotion",
                method: "POST",
                data: {
                    product_id: JSON.parse(productChoose.value),
                    promotion: promotion,
                },
            }).done((res) => {
                document.querySelector(".item-product").innerHTML = res.html;
                VOUCHER.paginationList();
                VOUCHER.removeProductOfVoucher();
                $("#modalProduct").modal("hide");
                $("#modalProduct .modal-content").html("");
            });
        }
        localStorage.removeItem("CHOOSE_" + promotion.toUpperCase());
    }

    async function applyProductForCombo(promotion) {
        const productChoose = document.querySelector(
            'textarea[name="product_choose"]'
        );
        if (productChoose !== null) {
            $.ajax({
                url: "tp/marketing/choose-product-for-promotion",
                method: "POST",
                data: {
                    product_id: JSON.parse(productChoose.value),
                    promotion: promotion,
                },
            }).done((res) => {
                document.querySelector(".item-product").innerHTML = res.html;
                M_CHECKBOX.refresh();
                COMBO._();
                COMBO.checkPriceProductForDiscount();
                $("#modalProduct").modal("hide");
                $("#modalProduct .modal-content").html("");
            });
        }
        localStorage.removeItem("CHOOSE_" + promotion.toUpperCase());
    }

    async function applyProductForFlashSale(promotion, action) {
        const productChoose = document.querySelector(
            'textarea[name="product_choose"]'
        );
        console.log(productChoose);
        if (productChoose !== null) {
            $.ajax({
                url: "tp/marketing/choose-product-for-promotion",
                method: "POST",
                data: {
                    product_id: JSON.parse(productChoose.value),
                    promotion: promotion,
                    action: action,
                },
            }).done((res) => {
                document.querySelector(".item-product").innerHTML = res.html;
                M_CHECKBOX.refresh();
                FLASH_SALE.loadModuleFlashSale();
                document.querySelector(
                    '.footer-form button[type="submit"]'
                ).disabled = false;
                $("#modalProduct").modal("hide");
                $("#modalProduct .modal-content").html("");
            });
        }
        localStorage.removeItem("CHOOSE_FLASH_SALE");
    }

    async function applyProductForDeal(promotion, action, type) {
        let isPass = true;
        const productChoose = document.querySelector(
            'textarea[name="product_choose"]'
        );
        if (productChoose !== null) {
            isPass = $.ajax({
                url: "tp/marketing/choose-product-for-promotion",
                method: "POST",
                data: {
                    product_id: JSON.parse(productChoose.value),
                    promotion: promotion,
                    type: type,
                    action: action,
                },
            }).done((res) => {
                if (res.code == 100) {
                    isPass = false;
                    AJAX_PROMOTION.alert(res);
                } else {
                    const editDeal = document.querySelector(".edit-deal");
                    if (
                        res.type == "main" &&
                        res.count > 0 &&
                        editDeal &&
                        !editDeal.classList.contains("no-edit")
                    ) {
                        editDeal.classList.add("no-edit");
                    } else if (res.type == "main" && editDeal) {
                        editDeal.classList.remove("no-edit");
                    }

                    const editProductMain =
                        document.querySelector(".edit-product-main");

                    if (
                        res.type == "sub" &&
                        res.count > 0 &&
                        editProductMain &&
                        !editProductMain.classList.contains("no-edit")
                    ) {
                        editProductMain.classList.add("no-edit");
                    } else if (res.type == "sub" && editProductMain) {
                        editProductMain.classList.remove("no-edit");
                    }

                    document.querySelector(`.item-product-${type}`).innerHTML =
                        res.html;
                    M_CHECKBOX.refresh();
                    DEAL._();
                    $("#modalProduct").modal("hide");
                    $("#modalProduct .modal-content").html("");
                }
            });
        }
        localStorage.removeItem("CHOOSE_" + promotion.toUpperCase());
        return isPass;
    }

    function showAndHideProductSelected() {
        let timeout;
        const inputChecked = document.querySelector("#product_has_promotion");
        if (!inputChecked) return;
        inputChecked.onchange = async () => {
            clearTimeout(timeout);
            let data = new FormDataRS("filter", false);
            data = data.getObjectData();
            data["product_chooses"] = localStorage.getItem(
                inputChecked
                    .closest(".modal-content")
                    .getAttribute("m-checkbox")
                    .toUpperCase()
            );
            timeout = setTimeout(() => {
                searchProduct(data);
            }, 500);
        };
    }

    function searchProduct(data) {
        $.ajax({
            url: "tp/marketing/search-product",
            type: "POST",
            data: data,
        }).done((res) => {
            const customList = document.querySelector("#modalProduct table");
            customList.innerHTML = res.html;
            paginateCategory();
            M_CHECKBOX.refresh();
        });
    }
    return {
        _: () => {
            showModal();
        },
    };
})();

var AJAX_PROMOTION = (function () {
    function createSuccess(json) {
        if (json.code == 200) {
            $.simplyToast(json.message, "success");
            if (json.redirect_url) {
                return (window.location.href = json.redirect_url);
            }
        } else {
            $.simplyToast(json.message, "danger");
        }
    }

    function alert(json) {
        if (json.code == 200 && json.message) {
            $.simplyToast(json.message, "success");
        } else if (json.code == 100 && json.message) {
            $.simplyToast(json.message, "danger");
        }
    }
    return {
        createSuccess: function (json) {
            createSuccess(json);
        },
        alert: function (json) {
            alert(json);
        },
    };
})();

window.addEventListener("DOMContentLoaded", function () {
    BASE._();
    MODALPRODUCT._();
});
