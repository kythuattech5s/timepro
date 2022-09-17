var FLASH_SALE = (() => {
    const BASE_URL = "tp/flash-sale/";

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
                var date = RS.convertDate(a[0]._d);
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
    return {
        _: () => {
            showModalFlashSaleSlot();
            saveSlotTime();
            editTimeSlot();
            chooseType();
            search();
            paginateCategory();
            changeInputSelected();
            M_CHECKBOX.refresh();
        },
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
});
