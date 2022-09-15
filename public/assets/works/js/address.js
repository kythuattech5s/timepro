var ADDRESS = (() => {
    return {
        add: (res) => {
            ADD_ADDRESS.success(res);
        },
        edit: (res) => {
            EDIT_ADDRESS.success(res);
        },
    };
})();
const defaultOptions = {
    modalSelector: "#address",
    listSelector: ".box-address",
    classRemove: ".item-delete",
    itemChoose: ".item-user-address",
    type: "ADD",
    editClass: ".edit",
};
class Address {
    constructor(options = defaultOptions) {
        this.options = {
            ...defaultOptions,
            ...options
        };
        this.list = document.querySelector(this.options.listSelector);
        if (!this.list) return;
        this.classRemove = this.options.classRemove;
        this.itemChoose = this.options.itemChoose;
        this.editClass = this.options.editClass;
        this.modal = document.querySelector(this.options.modalSelector);
        this.type = this.options.type;
        this.initModal();
    }

    initModal = () => {
        if (!this.modal) return;
        this.instanceModal = new bootstrap.Modal(this.modal, {
            keyboard: false,
        });
        this.modalContent = this.modal.querySelector(".modal-content");
        this.showModal();
        this.initFn();
    };
    initFn = () => {
        this.deleteItem();
        this.chooseItem();
        this.editItem();
    };
    editItem = () => {
        const buttons = this.list.querySelectorAll(this.editClass);
        buttons.forEach((button) => {
            button.onclick = (e) => {
                e.stopPropagation();
            };
        });
    };
    showModal = () => {
        this.modal.addEventListener("shown.bs.modal", async (e) => {
            let url;
            let data = {};
            let related = e.relatedTarget;
            url = related.dataset.url;
            if (this.type == "EDIT") {
                url = `${url}${related.dataset.id}`;
            }

            const response = await XHR.send({
                url: url,
                method: "GET",
                data: data,
            });

            this.modalContent.innerHTML = await response.html;

            new chooseAddress(
                this.modalContent,
                this.type == "ADD" ? false : true
            );
            VALIDATE_FORM.refresh();
        });
    };

    deleteItem = () => {
        const buttons = this.list.querySelectorAll(this.classRemove);
        buttons.forEach((button) => {
            button.onclick = (e) => {
                e.stopPropagation();
                Swal.fire({
                    title: "Bạn muốn xóa địa chỉ này?",
                    showCancelButton: true,
                    confirmButtonText: "Xóa",
                    cancelButtonText: "Hủy",
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        const response = await XHR.send({
                            url: `${button.dataset.url}/${button.dataset.id}`,
                            method: "POST",
                        });
                        mySupport.showNotify(response.code, response.message);
                        this.list.innerHTML = response.html;
                        this.initFn();
                    }
                });
            };
        });
    };

    chooseItem = () => {
        const items = this.list.querySelectorAll(this.itemChoose);
        items.forEach((item) => {
            item.onclick = () => {
                if (item.hasAttribute("active-address")) {
                    return false;
                }

                Swal.fire({
                    title: "Bạn muốn đổi địa chỉ này thành địa chỉ mặc định?",
                    showCancelButton: true,
                    confirmButtonText: "Đồng ý",
                    cancelButtonText: "Hủy",
                }).then(async (result) => {
                    if (result.isConfirmed) {

                        XHR.send({
                            url: item.dataset.url,
                            method: "POST",
                            data: {
                                id: item.dataset.id,
                            },
                        }).then((response) => {
                            mySupport.showNotify(
                                response.code,
                                response.message
                            );
                            this.list.innerHTML = response.html;
                            this.initFn();
                        });
                    }
                });
            };
        });
    };
    success = (res) => {
        mySupport.showNotify(res.code, res.message);
        if (res.code == 200) {
            this.list.innerHTML = res.html;
            this.instanceModal.hide();
            this.modalContent.innerHTML = "";
            this.initFn();
        }
    };
}

const ADD_ADDRESS = new Address({
    modalSelector: "#address",
    listSelector: ".box-address",
    classRemove: ".item-delete",
    itemChoose: ".item-user-address",
    type: "ADD",
    editClass: ".edit",
});

const EDIT_ADDRESS = new Address({
    modalSelector: "#editAddress",
    listSelector: ".box-address",
    classRemove: ".item-delete",
    itemChoose: ".item-user-address",
    type: "EDIT",
    editClass: ".edit",
});
