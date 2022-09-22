(() => {
    const buttonApply = document.querySelector("[apply-voucher]");
    if (!buttonApply) return;
    buttonApply.onclick = () => {
        const code = document.querySelector("[code-voucher]");
        if (code.value.trim() == "") {
            return NOTIFICATION.showNotify(100, "Vui lòng nhập mã giảm giá!");
        }
        let url = "tpv/voucher/ap-dung-ma-giam-gia";
        let isApply = true;
        if (buttonApply.getAttribute("apply-voucher") === "true") {
            url = "tpv/voucher/huy-ap-dung-ma-giam-gia";
            isApply = false;
        }
        XHR.send({
            url: url,
            method: "POST",
            data: {
                code: code.value,
            },
            button: buttonApply,
        }).then((res) => {
            if (res.code == 200) {
                buttonApply.setAttribute("apply-voucher", isApply ? true : "");
                buttonApply.innerHTML = isApply ? "Bỏ áp dụng" : "Áp dụng";
                code.disabled = isApply;
                document.querySelector("[content-total]") &&
                    (document.querySelector("[content-total]").innerHTML =
                        res.html);
            }
            NOTIFICATION.showNotify(res.code, res.message);
        });
    };
})();
