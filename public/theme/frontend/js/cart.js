"use strict";
var CART = (function () {
    var buyItemBoxs = document.querySelectorAll(".buy-item-box");
    var setUpBuyItemBox = function () {
        buyItemBoxs.forEach((buyItemBox) => {
            var mainPriceElm = buyItemBox.querySelector(".item-price-main");
            var subPriceElm = buyItemBox.querySelector(".item-price-sub");
            var selectTimePackage = buyItemBox.querySelector(
                ".select-time-package"
            );
            var btnBuyItems = buyItemBox.querySelectorAll(".btn-buy-item");

            if (selectTimePackage) {
                var firstPackage = selectTimePackage.item(
                    selectTimePackage.selectedIndex
                );
                _changePriceShow(firstPackage, mainPriceElm, subPriceElm);
                selectTimePackage.addEventListener("change", function () {
                    btnBuyItems.forEach((btnBuyItem) => {
                        btnBuyItem.setAttribute(
                            "data-package",
                            selectTimePackage.value
                        );
                    });
                    var selectedPackage = this.item(this.selectedIndex);
                    _changePriceShow(
                        selectedPackage,
                        mainPriceElm,
                        subPriceElm
                    );
                });
            }

            btnBuyItems.forEach((btnBuyItem) => {
                btnBuyItem.addEventListener("click", function () {
                    _initButtonBuyItem(this);
                });
            });
        });
    };
    var _changePriceShow = function (
        selectedPackage,
        mainPriceElm,
        subPriceElm
    ) {
        var mainPrice = selectedPackage ? selectedPackage.dataset.price : "";
        var subPrice = selectedPackage ? selectedPackage.dataset.subprice : "";
        if (mainPriceElm) {
            mainPriceElm.innerHTML = mainPrice;
        }
        if (subPriceElm) {
            subPriceElm.innerHTML = subPrice;
        }
    };
    var _initButtonBuyItem = function (button) {
        BASE_GUI.disableButton(button);
        const formData = new FormData();
        formData.append("type", button.dataset.type);
        formData.append("action", button.dataset.action);
        formData.append("id", button.dataset.id);
        formData.append("package", button.dataset.package);
        XHR.send({
            url: "cart/add",
            method: "POST",
            formData: formData,
        }).then((res) => {
            BASE_GUI.enableButton(button);
            NOTIFICATION.toastrMessageRedirect(res);
        });
    };
    return {
        _: function () {
            setUpBuyItemBox();
        },
    };
})();
window.addEventListener("DOMContentLoaded", function () {
    CART._();
});
