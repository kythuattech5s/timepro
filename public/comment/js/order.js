class commentOrder {
    constructor(modalId) {
        this.modal = document.querySelector(`#${modalId}`);
        if (!this.modal) {
            return alert("Không tồn tại modal");
        }
        this.modalInstance = bootstrap.Modal.getInstance(this.modal);
        this.init();
    }

    init = () => {
        this.modal.addEventListener("shown.bs.modal", this.eventShown);
    };

    eventShown = (e) => {
        const button = e.relatedTarget;
        XHR.send({
            url: "cmrs/source/danh-gia-san-pham",
            method: "GET",
            data: {
                id: button.dataset.id,
            },
        }).then((res) => {
            this.modal.querySelector(".modal-content").innerHTML = res.html;
            this.initRating();
            VALIDATE_FORM.refresh();
        });
    };

    initRating = () => {
        const listItems = this.modal.querySelectorAll(".product-rating");
        listItems.forEach((item) => {
            const listRating = item.querySelectorAll('[type="radio"]');
            listRating.forEach((inputStar) => {
                inputStar.addEventListener("change", () => {
                    const headForm = inputStar.closest(".head-form");
                    const formCommnet = headForm.nextElementSibling;
                    formCommnet.classList.remove("d-none");
                });
            });
        });
    };
}

new commentOrder("ratingOrder");

var COMMENT_ORDER = (() => {
    return {
        success: (res) => {
            mySupport.showNotify(res.code, res.message);
            window.location.reload();
        },
    };
})();
