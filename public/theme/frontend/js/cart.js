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
            initCartCount();
        });
    };
    var initCartCount = function () {
        XHR.send({
            url: "cart/get-count",
            method: "POST",
        }).then((res) => {
            var countItemCartBoxs =
                document.querySelectorAll(".count-item-cart");
            countItemCartBoxs.forEach((countItemCartBox) => {
                countItemCartBox.innerHTML = res.count ? res.count : 0;
            });
        });
    };
    var initDeleteItemCart = function () {
        var listItembtnDeleteItemCart = document.querySelectorAll(
            ".btn-delete-item-cart"
        );
        listItembtnDeleteItemCart.forEach((itembtnDeleteItemCart) => {
            itembtnDeleteItemCart.addEventListener("click", function () {
                var _this = this;
                BASE_GUI.disableButton(_this);
                const formData = new FormData();
                formData.append("row", itembtnDeleteItemCart.dataset.row);
                formData.append(
                    "instance",
                    itembtnDeleteItemCart.dataset.instance
                );
                XHR.send({
                    url: "cart/delete-item",
                    method: "POST",
                    formData: formData,
                }).then((res) => {
                    BASE_GUI.enableButton(_this);
                    initCartCount();
                    if (res.code == 200) {
                        window.location.reload();
                    } else {
                        NOTIFICATION.toastrMessage(res);
                    }
                });
            });
        });
    };
    var showPaymentMethodContent = function () {
        var listPaymentMethodItem = document.querySelectorAll(
            ".payment-method__item"
        );
        var listMethodDes = document.querySelectorAll(
            ".payment-method__item .method-des"
        );
        listPaymentMethodItem.forEach((itemPaymentMethodItem) => {
            var inputValue = itemPaymentMethodItem.querySelector("input");
            var methodDes = itemPaymentMethodItem.querySelector(".method-des");
            if (inputValue) {
                inputValue.addEventListener("change", function () {
                    listMethodDes.forEach((itemMethodDes) => {
                        itemMethodDes.classList.remove("show");
                    });
                    if (methodDes) {
                        methodDes.classList.add("show");
                    }
                });
            }
        });
    };
    return {
        _: function () {
            setUpBuyItemBox();
            initCartCount();
            initDeleteItemCart();
            showPaymentMethodContent();
        },
    };
})();
window.addEventListener("DOMContentLoaded", function () {
    CART._();
});
