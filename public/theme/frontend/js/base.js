var NOTIFICATION = {
    toastrMessage: function (data) {
        NOTIFICATION.showNotify(data.code, data.message);
    },
    toastrMessageReload: function (data) {
        NOTIFICATION.showNotify(data.code, data.message);
        if (data.code == 200) {
            window.location.reload();
        }
    },
    toastrMessageRedirect: function (data) {
        if (data.redirect_url) {
            if (data.code == 200) {
                window.location.href = data.redirect_url;
            }
        } else {
            NOTIFICATION.showNotify(data.code, data.message);
        }
    },
    showNotifyWhenLoadPage() {
        if (
            typeNotify != "undefined" &&
            typeNotify != undefined &&
            typeNotify != "" &&
            messageNotify != "undefined" &&
            messageNotify != undefined &&
            messageNotify != ""
        ) {
            var code = typeNotify;
            this.showNotify(code, messageNotify);
        }
    },
    showNotify(code, message) {
        for (const toastr of document.querySelectorAll(".toastify")) {
            toastr.remove();
        }
        Toastify({
            text: message,
            close: true,
            style: {
                background:
                    code == 200
                        ? "linear-gradient(to right, rgb(0, 176, 155), rgb(150, 201, 61))"
                        : "linear-gradient(to right, rgb(255, 95, 109), rgb(255, 195, 113))",
            },
        }).showToast();
    },
};
window.addEventListener("DOMContentLoaded", function () {
    NOTIFICATION.showNotifyWhenLoadPage();
});
