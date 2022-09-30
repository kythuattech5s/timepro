var MORE_FUNCTION = (function () {
    var showModal = function (element) {
        var modal_id = element.getAttribute("data-modal");
        var modal = document.getElementById(modal_id);
        modal.classList.toggle("active");
    };
    var closeModal = function () {
        var button_close_modal = document.querySelectorAll(
            "button[button_close_modal]"
        );
        button_close_modal.forEach((item) => {
            item.addEventListener("click", function () {
                var _this = this;
                _this.closest("div[modal]").classList.remove("active");
            });
        });
        window.onclick = function (event) {
            var modal = document.querySelector("div[modal]");
            if (event.target == modal) {
                modal.classList.remove("active");
            }
        };
    };
    var configDatetimeRange = function () {
        var time_range_flatpickr = document.querySelectorAll(
            "[time_range_flatpickr]"
        );
        time_range_flatpickr.forEach((item) => {
            flatpickr(item, {
                enableTime: false,
                dateFormat: "d/m/Y",
                mode: "range",
                locale: "vn",
                maxDate: new Date(),
            });
        });
    };

    var changeBirthDayProfile = function (element) {
        var _this = element;
        var type = _this.getAttribute("data-type");
        if (type == "year") {
            document.querySelector('select[data-type="month"]').value = "0";
            document.querySelector('select[data-type="day"]').value = "0";
        }
        if (type == "month") {
            document.querySelector('select[data-type="day"]').value = "0";
            var dayOld = document
                .querySelector('select[data-type="day"]')
                .getAttribute("data-day");
            XHR.send({
                url: "get-last-dat-of-month",
                method: "POST",
                data: {
                    year: document.querySelector('select[data-type="year"]')
                        .value,
                    month: document.querySelector('select[data-type="month"]')
                        .value,
                    day: dayOld,
                },
            }).then((res) => {
                document.querySelector('select[data-type="day"]').innerHTML =
                    res.html;
            });
        }
        if (type == "day") {
            var birday =
                document.querySelector('select[data-type="year"]').value +
                "-" +
                document.querySelector('select[data-type="month"]').value +
                "-" +
                _this.value;
            document.querySelector('input[name="birthday"]').value = birday;
        }
    };

    var getDistrictByProvince = function () {
        var provinces = document.querySelectorAll("select[province]");
        provinces.forEach(function (item) {
            item.addEventListener("change", function () {
                var district_select =
                    document.querySelector("select[district]");
                var district_value = district_select.getAttribute("data-value");
                XHR.send({
                    url:
                        "get-district-by-province?province_id=" +
                        this.value +
                        "&district_id=" +
                        district_value,
                    method: "GET",
                }).then((res) => {
                    district_select.innerHTML = res.html;
                    district_select.disabled = false;
                });
            });
        });
    };

    var getWardByDistrict = function () {
        var provinces = document.querySelectorAll("select[district]");
        provinces.forEach(function (item) {
            item.addEventListener("change", function () {
                var ward_select = document.querySelector("select[ward]");
                var ward_value = ward_select.getAttribute("data-value");
                XHR.send({
                    url:
                        "get-ward-by-district?district_id=" +
                        this.value +
                        "&ward_id=" +
                        ward_value,
                    method: "GET",
                }).then((res) => {
                    ward_select.innerHTML = res.html;
                    ward_select.disabled = false;
                });
            });
        });
    };

    var triggerEvent = function () {
        var selectMonth = document.querySelector('select[data-type="month"]');
        var selectDistrict = document.querySelector("select[district]");
        var selectProvince = document.querySelector("select[province]");
        var event = new Event("change");
        if (selectMonth != undefined) {
            selectMonth.dispatchEvent(event);
        }

        if (selectProvince != undefined) {
            selectProvince.dispatchEvent(event);
            selectDistrict.disabled = true;
        }

        if (selectDistrict != undefined) {
            document.querySelector("select[ward]").disabled = true;
            setTimeout(() => {
                selectDistrict.dispatchEvent(event);
            }, 2000);
        }
    };

    var exportHistoryWallet = function (element) {
        var href = element.getAttribute("data-action");
        window.location.href =
            href +
            "?range_time=" +
            document.querySelector('input[name="range_time"]');
    };

    var filterHistoryWallet = function (element) {
        var _this = element;
        var form = _this.closest("form");
    };
    var resizeIframe = function (id) {
        var newheight;
        var newwidth;
        document.getElementById(id).style.width = "100%";
        if (document.getElementById) {
            newheight =
                document.getElementById(id).contentWindow.document.body
                    .scrollHeight;

            newwidth =
                document.getElementById(id).contentWindow.document.body
                    .scrollWidth;
        }
        document.getElementById(id).height = newheight + 10 + "px";
        document.getElementById(id).width = newwidth + "px";
    };
    return {
        init: function () {
            closeModal();
            configDatetimeRange();
            getDistrictByProvince();
            getWardByDistrict();
            triggerEvent();
        },
        showModal: function (element) {
            showModal(element);
        },
        changeBirthDayProfile: function (element) {
            changeBirthDayProfile(element);
        },
        exportHistoryWallet: function (element) {
            exportHistoryWallet(element);
        },
        filterHistoryWallet: function (element) {
            filterHistoryWallet(element);
        },
        resizeIframe: function (id) {
            resizeIframe(id);
        },
    };
})();
MORE_FUNCTION.init();
