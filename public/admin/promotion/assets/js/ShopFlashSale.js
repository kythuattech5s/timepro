var SHOP_FLASHSALE = (() => {
    const activeFlashSale = () => {
        const checkInputs = document.querySelectorAll(".active-now");
        checkInputs.forEach((input) => {
            input.onchange = () => {
                if (input.checked) {
                    $.ajax({
                        url: "esystem/flash-sales/active",
                        method: "POST",
                        data: {
                            id: input.closest("tr").dataset.id,
                        },
                    }).done((res) => {
                        if (res.code == 200) {
                            $.simplyToast(res.message, "success");
                        } else {
                            $.simplyToast(res.message, "danger");
                        }
                    });
                }
            };
        });
    };

    return {
        _: () => {
            activeFlashSale();
        },
    };
})();

window.addEventListener("DOMContentLoaded", function () {
    SHOP_FLASHSALE._();
});
