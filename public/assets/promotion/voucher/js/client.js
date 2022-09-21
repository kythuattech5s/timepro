/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************************!*\
  !*** ./packages/tech5s/voucher/resources/js/client.js ***!
  \********************************************************/
(function () {
  var buttonApply = document.querySelector("[apply-voucher]");
  if (!buttonApply) return;

  buttonApply.onclick = function () {
    var code = document.querySelector("[code-voucher]");

    if (code.value.trim() == "") {
      return NOTIFICATION.showNotify(100, "Vui lòng nhập mã giảm giá!");
    }

    var url = "tpv/voucher/ap-dung-ma-giam-gia";
    var isApply = true;

    if (buttonApply.getAttribute("apply-voucher") === "true") {
      url = "tpv/voucher/huy-ap-dung-ma-giam-gia";
      isApply = false;
    }

    XHR.send({
      url: url,
      method: "POST",
      data: {
        code: code.value
      },
      button: buttonApply
    }).then(function (res) {
      if (res.code == 200) {
        buttonApply.setAttribute("apply-voucher", isApply ? true : "");
        buttonApply.innerHTML = isApply ? "Bỏ áp dụng" : "Áp dụng";
        code.disabled = isApply;
        document.querySelector("[content-total]") && (document.querySelector("[content-total]").innerHTML = res.html);
      }

      NOTIFICATION.showNotify(res.code, res.message);
    });
  };
})();
/******/ })()
;