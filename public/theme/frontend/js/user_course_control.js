"use strict";
var MY_COURSE = (function () {
    var fillterMyCourse = function () {
        var formFillterMyCourse = document.querySelector(
            "#form-fillter-my-course"
        );
        if (!formFillterMyCourse) {
            return;
        }
        var listItemFillter =
            formFillterMyCourse.querySelectorAll(".item-fillter");
        listItemFillter.forEach((itemFillter) => {
            itemFillter.addEventListener("change", function () {
                formFillterMyCourse.submit();
            });
        });
    };
    return {
        _: function () {
            fillterMyCourse();
        },
    };
})();
var MY_ORDER = (function () {
    var cancelOrder = function () {
        var listBtnAcceptCancelOrder = document.querySelectorAll(
            ".btn-accept-cancel-order"
        );
        listBtnAcceptCancelOrder.forEach((btnAcceptCancelOrder) => {
            btnAcceptCancelOrder.addEventListener("click", function () {
                var _this = this;
                BASE_GUI.disableButton(_this);
                const formData = new FormData();
                formData.append("order", this.dataset.order);
                XHR.send({
                    url: "huy-don-hang",
                    method: "POST",
                    formData: formData,
                }).then((res) => {
                    BASE_GUI.enableButton(_this);
                    NOTIFICATION.toastrMessageReload(res);
                });
            });
        });
    };
    var restoreOrder = function () {
        var listBtnRestoreOrder =
            document.querySelectorAll(".btn-restore-order");
        listBtnRestoreOrder.forEach((btnRestoreOrder) => {
            btnRestoreOrder.addEventListener("click", function () {
                var _this = this;
                BASE_GUI.disableButton(_this);
                const formData = new FormData();
                formData.append("order", this.dataset.order);
                XHR.send({
                    url: "mua-lai-don-hang",
                    method: "POST",
                    formData: formData,
                }).then((res) => {
                    BASE_GUI.enableButton(_this);
                    NOTIFICATION.toastrMessageRedirect(res);
                });
            });
        });
    };
    return {
        _: function () {
            cancelOrder();
            restoreOrder();
        },
    };
})();
window.addEventListener("DOMContentLoaded", function () {
    MY_COURSE._();
    MY_ORDER._();
});
