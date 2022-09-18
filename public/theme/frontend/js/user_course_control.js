"use strict";
var MY_ORDER = (function () {
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
                    NOTIFICATION.toastrMessage(res);
                });
            });
        });
    };
    return {
        _: function () {
            restoreOrder();
        },
    };
})();
window.addEventListener("DOMContentLoaded", function () {
    MY_ORDER._();
});
