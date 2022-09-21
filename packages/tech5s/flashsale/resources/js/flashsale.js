import Helper from "../../../../roniejisa/scripts/assets/js/Helper.js";

var BASE_VOUCHER = (() => {
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
                inputEl.value = await Helper.number_format(val);
                inputCurrent.value = val;
                inputCurrent.dispatchEvent(new Event("input"));
            });
        });
    };

    return {
        _: () => {
            scroll();
            format();
        },
    };
})();

var MODALPRODUCT = (() => {
    function showModal() {
        $("#modalProduct").on("shown.bs.modal", async function (e) {
            const _this = $(this);
            await FLASH_SALE.saveProductCurrent();

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
                url: "tpf/flashsale/show-product",
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
                    data["item_chooses"] = localStorage.getItem(
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
        const formButton = document.querySelector(
            '.form-search-item [type="button"]'
        );

        if (!formButton) return;
        let timeout;
        formButton.onclick = () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                let data = new FormDataRS("filter", false);
                data = data.getObjectData();
                const inputChecked = document.querySelector(
                    "#product_has_promotion"
                );
                data["item_chooses"] = localStorage.getItem(
                    inputChecked
                        .closest(".modal-content")
                        .getAttribute("m-checkbox")
                        .toUpperCase()
                );
                searchProduct(data);
            }, 400);
        };
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
                const isPass = await applyProductForFlashSale(
                    promotion,
                    action
                );
            };
        }
    }

    async function applyProductForFlashSale(promotion) {
        const productChoose = document.querySelector(
            'textarea[name="product_choose"]'
        );
        if (productChoose !== null) {
            $.ajax({
                url: "tpf/flashsale/choose-product-for-promotion",
                method: "POST",
                data: {
                    item_id: JSON.parse(productChoose.value),
                    promotion: promotion,
                },
            }).done((res) => {
                document.querySelector(".item-product").innerHTML = res.html;
                FLASH_SALE.paginationList();
                FLASH_SALE.removeProductOfFlashSale();
                FLASH_SALE.updateForAll();
                $("#modalProduct").modal("hide");
                $("#modalProduct .modal-content").html("");
            });
        }
        localStorage.removeItem("CHOOSE_" + promotion.toUpperCase());
    }

    function showAndHideProductSelected() {
        let timeout;
        const inputChecked = document.querySelector("#product_has_promotion");
        if (!inputChecked) return;
        inputChecked.onchange = async () => {
            clearTimeout(timeout);
            let data = new FormDataRS("filter", false);
            data = data.getObjectData();
            data["item_chooses"] = localStorage.getItem(
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
            url: "tpf/flashsale/search-product",
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

var FLASH_SALE = (() => {
    const BASE_URL = "tpf/flashsale/";

    function createUrl(url) {
        return BASE_URL + url;
    }

    function showModalFlashSaleSlot() {
        $("#flashSaleSlot").on("shown.bs.modal", function (e) {
            calendar();
        });
    }

    var calendar = function () {
        if ($(".calendar").length == 0) return;
        const dateCurrent = document.querySelector("[name=datetime]").value;
        getSlotTime(dateCurrent);
        $(".calendar").pignoseCalendar({
            lang: "en",
            theme: "light",
            date: dateCurrent,
            format: "DD-MM-YYYY",
            classOnDays: [],
            enabledDates: [],
            disabledDates: [],
            disabledWeekdays: [],
            disabledRanges: [],
            schedules: [],
            scheduleOptions: {
                colors: {},
            },
            week: 1,
            monthsLong: [
                "Tháng 1",
                "Tháng 2",
                "Tháng 3",
                "Tháng 4",
                "Tháng 5",
                "Tháng 6",
                "Tháng 7",
                "Tháng 8",
                "Tháng 9",
                "Tháng 10",
                "Tháng 11",
                "Tháng 12",
            ],
            weeks: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
            pickWeeks: false,
            initialize: true,
            multiple: false,
            toggle: false,
            buttons: false,
            reverse: false,
            modal: false,
            buttons: false,
            minDate: null,
            maxDate: null,
            select: function (a) {
                if (!a[0]?._d) return;
                var date = Helper.convertDate(a[0]._d);
                $(this).closest("td").find('input[name="datetime"]').remove();
                $(this)
                    .closest("tr")
                    .find("td:first")
                    .prepend(
                        '<input name="datetime" type="date" hidden value="' +
                            date +
                            '">'
                    );
                getSlotTime(date);
            },
            selectOver: false,
            apply: function (a) {},
            click: null,
        });
    };

    var getSlotTime = function (date) {
        $.ajax({
            url: createUrl("find-slot-time"),
            type: "POST",
            data: {
                date,
            },
        }).done(function (json) {
            const listSlotTime = document.querySelector(
                ".list-hour-prd-flash-check"
            );
            listSlotTime.innerHTML = json.html;
            if (json.slot_time_id) {
                listSlotTime.querySelector(
                    `input[value="${json.slot_time_id}"]`
                ).checked = true;
            }
        });
    };

    var saveSlotTime = function () {
        const btnSubmit = document.querySelector(".btn-create-slot-time");
        if (!btnSubmit) return;
        btnSubmit.onclick = function (e) {
            e.preventDefault();
            const date = document.querySelector("[type=date]");
            const time = document.querySelector('[name="slot_time"]:checked');
            if (!date || !time) {
                return $.simplyToast(
                    "Vui lòng chọn ngày và khung giờ",
                    "danger"
                );
            }
            $.ajax({
                url: createUrl("create-time-slot"),
                type: "POST",
                data: {
                    date: date.value,
                    time_slot: time.value,
                },
            }).done((res) => {
                if (res.code == 100) {
                    return $.simplyToast(res.message, "danger");
                }
                document.querySelector(".flash-sale-datetime").innerHTML =
                    res.html;
                editTimeSlot();

                $("#flashSaleSlot").modal("hide");
                if (document.querySelector(".modal-backdrop")) {
                    document.querySelector(".modal-backdrop").remove();
                    document.body.classList.remove("modal-open");
                }
                VALIDATE_FORM.refresh();
                FLASH_SALE._();
            });
        };
    };

    var editTimeSlot = () => {
        const spanEdit = document.querySelector(".flash-sale-editable");
        if (!spanEdit) return;
        spanEdit.ondblclick = function () {
            XHR.send({
                url: createUrl("edit-time-slot"),
                method: "POST",
            }).then((res) => {
                if (res.code == 100) {
                    AJAX_PROMOTION.alert(res);
                } else {
                    document.querySelector(".flash-sale-datetime").innerHTML =
                        res.html;
                    FLASH_SALE._();
                }
            });
        };
    };

    var chooseType = () => {
        const type = document.querySelector("[name=promotion_type_id]");
        if (!type) return;
        const customList = document.querySelector(".list-result-custom");
        const searchEl = document.querySelector(".custom-search");
        type.onchange = function () {
            customList.innerHTML = "";
            if (type.value === "") {
                customList.classList.add("hidden");
                return;
            }
            $.ajax({
                url: createUrl("choose-promotion-type"),
                type: "POST",
                data: {
                    type: type.value,
                },
            }).done((res) => {
                customList.innerHTML = res.html;
                customList.classList.remove("hidden");
                searchEl.innerHTML = res.search_html;
                searchEl.classList.remove("hidden");
                search();
                M_CHECKBOX.refresh();
                paginateCategory();
            });
        };
    };

    function search() {
        let timeout;
        const filterSubmit = document.querySelector(".submit-search");
        if (!filterSubmit) return;

        filterSubmit.onclick = function () {
            const input = filterSubmit.previousElementSibling;
            if (input.value == "") clearTimeout(timeout);
            timeout = setTimeout(() => {
                const customList = document.querySelector(
                    ".list-result-custom"
                );
                $.ajax({
                    url: createUrl("search"),
                    type: "POST",
                    data: {
                        q: input.value,
                        isShow: document.querySelector("#selected-category")
                            .checked
                            ? "on"
                            : 0,
                        listChecked: localStorage.getItem(
                            input
                                .closest(".custom-search")
                                .nextElementSibling.querySelector(
                                    "[m-checkbox]"
                                )
                                .getAttribute("m-checkbox")
                                .toUpperCase()
                        ),
                    },
                }).done((res) => {
                    customList.innerHTML = res.html;
                    paginateCategory();
                    M_CHECKBOX.refresh();
                });
            }, 300);
        };
    }

    function paginateCategory() {
        const paginate = document.querySelectorAll("[pagination-filter]");
        paginate.forEach((pagination) => {
            const paginateList = pagination.getElementsByTagName("a");
            Array.from(paginateList).forEach((anchorEl) => {
                anchorEl.onclick = function (e) {
                    e.preventDefault();
                    const getAttribute = new FormDataRS("data-category");
                    const data = getAttribute.getObjectData();
                    data["page"] = anchorEl.dataset.page;
                    data["listChecked"] = localStorage.getItem(
                        anchorEl
                            .closest("[m-checkbox]")
                            .getAttribute("m-checkbox")
                            .toUpperCase()
                    );
                    $.ajax({
                        url: createUrl("search"),
                        type: "POST",
                        data: data,
                    }).done((res) => {
                        const customList = document.querySelector(
                            ".list-result-custom"
                        );
                        customList.innerHTML = res.html;
                        paginateCategory();
                        M_CHECKBOX.refresh();
                    });
                };
            });
        });
    }

    function changeInputSelected() {
        const buttonSelected = document.querySelector("#selected-category");
        if (!buttonSelected) return;
        let timeout;
        buttonSelected.onchange = function () {
            timeout = setTimeout(() => {
                const getAttribute = new FormDataRS("data-category");
                const data = getAttribute.getObjectData();
                data["listChecked"] = localStorage.getItem(
                    document
                        .querySelector(".list-result-custom [m-checkbox]")
                        .getAttribute("m-checkbox")
                        .toUpperCase()
                );
                ajaxSearch(data);
            }, 300);
        };
    }

    function ajaxSearch(data) {
        $.ajax({
            url: createUrl("search"),
            type: "POST",
            data: data,
        }).done((res) => {
            const customList = document.querySelector(".list-result-custom");
            customList.innerHTML = res.html;
            paginateCategory();
            M_CHECKBOX.refresh();
        });
    }

    function totalDataCurrent() {
        const items = document.querySelectorAll(".list-product tbody tr");
        const listData = [];
        items.forEach((item) => {
            listData.push({
                id: item.dataset.id,
                discount: item.querySelector("[name='discount']").value,
                act: item.querySelector("[name='act']").value,
            });
        });

        return listData;
    }

    const saveProductCurrent = async () => {
        const listData = totalDataCurrent();
        return await XHR.send({
            url: "tpf/flashsale/save-product-current",
            method: "POST",
            data: {
                listItems: JSON.stringify(listData),
            },
        }).then((res) => {
            return true;
        });
    };

    function saveProductFlashSale() {
        const buttonSaveProduct = document.querySelector(
            ".save-product-flashsale"
        );
        if (!buttonSaveProduct) return;
        buttonSaveProduct.onclick = async () => {
            await saveProductCurrent();
            XHR.send({
                url: "tpf/flashsale/save-product",
                method: "POST",
            }).then((res) => {
                $.simplyToast(res.message, "success");
                window.location.href = res.redirect_url;
            });
        };
    }

    function updateForAll() {
        const buttonUpdateForAll = document.querySelector(".update-for-all");
        if (!buttonUpdateForAll) return;
        buttonUpdateForAll.onclick = () => {
            XHR.send({
                url: "tpf/flashsale/update-for-all",
                method: "POST",
                data: {
                    act: document.querySelector("[name='act_all']").value,
                    discount: document.querySelector("[name='discount_all']")
                        .value,
                },
            }).then((res) => {
                const listProduct = document.querySelector(".list-product");
                listProduct.innerHTML = res.html;
                FLASH_SALE.paginationList();
                FLASH_SALE.removeProductOfFlashSale();
            });
        };
    }

    const paginateLoad = () => {
        const paginationEl = document.querySelectorAll(
            "[pagination-flashsale-list] a"
        );
        paginationEl.forEach((el) => {
            el.onclick = async (e) => {
                e.preventDefault();
                await saveProductCurrent();
                const promotion = el.dataset.promotion;
                const page = el.dataset.page;
                $.ajax({
                    url: "tpf/flashsale/load-product",
                    method: "POST",
                    data: {
                        page,
                        promotion,
                    },
                }).then((res) => {
                    el.closest(".list-product").innerHTML = res.html;
                    FLASH_SALE.paginationList();
                    FLASH_SALE.removeProductOfFlashSale();
                });
            };
        });
    };

    const removeProduct = () => {
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
                                url: "tpf/flashsale/remove-product",
                                method: "POST",
                                data: {
                                    id: button.closest("tr").dataset.id,
                                },
                            }).done((res) => {
                                if (res.count == 0) {
                                    document.querySelector(
                                        ".item-product"
                                    ).innerHTML = `<button type="button" class="btn bg-green-400 text-white" data-toggle="modal" data-target="#modalProduct" data-type="flashsale">
                        Thêm sản phẩm
                    </button>`;
                                } else {
                                    button.closest(".list-product").innerHTML =
                                        res.html;
                                    document.querySelector(
                                        ".count-product-chooses"
                                    ).innerHTML = res.count;
                                    FLASH_SALE.paginationList();
                                    FLASH_SALE.removeProductOfFlashSale();
                                }
                            });
                        }
                    }
                );
            };
        });
    };
    return {
        _: () => {
            showModalFlashSaleSlot();
            saveSlotTime();
            editTimeSlot();
            chooseType();
            search();
            paginateCategory();
            saveProductFlashSale();
            changeInputSelected();
            updateForAll();
            paginateLoad();
            M_CHECKBOX.refresh();
        },
        saveProductFlashSale: () => {
            saveProductFlashSale();
        },
        updateForAll: () => {
            updateForAll();
        },
        paginationList: () => {
            paginateLoad();
        },
        saveProductCurrent: async () => {
            await saveProductCurrent();
        },
        removeProductOfFlashSale: () => {
            removeProduct();
        },
    };
})();

window["FLASH_SALE"] = (() => {
    return {
        createSuccess: (json) => {
            if (json.code == 200) {
                $.simplyToast(json.message, "success");
                if (json.redirect_url) {
                    window.location.href = json.redirect_url;
                }
            } else {
                $.simplyToast(json.message, "danger");
            }
        },
        checkTime: () => {
            if (
                document.querySelector('button[data-target="#flashSaleSlot"]')
            ) {
                $.simplyToast("Vui lòng chọn khung giờ", "danger");
                return false;
            }
            return true;
        },
    };
})();

window.addEventListener("DOMContentLoaded", function () {
    FLASH_SALE._();
    BASE_VOUCHER._();
    MODALPRODUCT._();
});
