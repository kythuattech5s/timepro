var ORDER_CANCEL = (function () {
    var showModal = function () {
        var modal = document.getElementById("cancelOrder");
        if (!modal) return;
        modal.addEventListener("shown.bs.modal", (e) => {
            const button = e.relatedTarget;
            const id = button.dataset.id;
            var form = modal.querySelector("form");
            form.querySelector("input[name=order_id]").remove();
            form.insertAdjacentHTML(
                "afterbegin",
                `<input type="hidden" name="order_id" value="${id}"/>`
            );
        });
    };
    return {
        _: function () {
            showModal();
        },
        success: function (res) {
            mySupport.showNotify(res.code, res.message);
            if (res.redirect_url) {
                window.location.href = res.redirect_url;
            }
            window.location.reload();
        },
    };
})();
ORDER_CANCEL._();
