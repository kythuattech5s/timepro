class changeImage {
    constructor(input, target, attribute, getFileOld = false) {
        this.catchEventChange(input, target, attribute);
    }

    catchEventChange(input, target, attribute) {
        const avatar = document.querySelector(input);
        if (!avatar) return;
        const imagePreview = document.querySelector(target);
        let oldAvatar;
        let defaultAvatar;
        if (imagePreview && imagePreview.getAttribute(attribute) !== "") {
            defaultAvatar = imagePreview.getAttribute(attribute);
        }
        avatar.onchange = (e) => {
            if (e.target.value == "") {
                return imagePreview.setAttribute(attribute, defaultAvatar);
            }

            if (oldAvatar) {
                window.URL.revokeObjectURL(oldAvatar);
            }

            const url = window.URL.createObjectURL(e.target.files[0]);
            oldAvatar = url;
            imagePreview.style.display = "none";
            if (imagePreview) {
                imagePreview.setAttribute(attribute, url);
                imagePreview.style.display = "block";
            }
        };
    }
}

class changeMultipleImage {
    constructor(options, isLoadFileOld = false) {
        this.check = "element" in options && "attribute" in options;
        if (!this.check) {
            alert("Nhập tên Element chứa Input và Attribute của Gallery");
            return;
        }

        this.element = options.element;
        this.attribute = options.attribute;
        this.arrayClass = this.element.getAttribute("data-class").split(" ");
        this.oldFiles = [];
        this.oldURL = {};
        this.maxFile = this.element.getAttribute("max-file") ?? Infinity;
        this.maxFileSize =
            this.element.getAttribute("max-size") ?? 10240000 * 2; /* 10 MB */
        this.uploadImageInput = this.element.querySelector("input");
        this.previewImageBox = document.querySelector(
            `[ ${this.attribute}="${this.uploadImageInput.name.replace(
                "[]",
                ""
            )}" ]`
        );
        this.initInputUpload();
        if (isLoadFileOld) {
            this.pushFileOld();
        }
    }

    initInputUpload() {
        if (!this.uploadImageInput) return;
        this.uploadImageInput.addEventListener("change", (event) => {
            var files = Array.from(event.target.files);
            var filesArr = [];
            for (const file of files) {
                this.validateFileUpload(file, files) && filesArr.push(file);
            }
            var fileBuffer = new DataTransfer();
            [...Array.from(this.oldFiles), ...filesArr].forEach((file) =>
                fileBuffer.items.add(file)
            );
            var fileFinals = fileBuffer.files;
            this.uploadImageInput.files = fileFinals;
            this.oldFiles = fileFinals;
            this.updateFileList(filesArr);
        });
    }

    validateFileUpload(file, files) {
        if (Array.from(this.oldFiles).length + files.length > this.maxFile) {
            mySupport.showNotify(
                100,
                `Đã vượt qua số lượng file tối đa ${this.maxFile}!`
            );
            return false;
        }
        if (!["image.*", "video.*"].some((type) => file.type.match(type))) {
            mySupport.showNotify(
                100,
                "File không đúng định dạng Ảnh hoặc Video"
            );
            return false;
        }

        if (file.size > this.maxFileSize) {
            mySupport.showNotify(
                100,
                `Tệp ${file.name}: ${RS.humanFileSize(
                    file.size
                )} đã vượt quá dung lượng tối đa ${RS.humanFileSize(
                    this.maxFileSize
                )}!`
            );
            return false;
        }

        if (!Array.from(this.oldFiles).some((item) => item.name == file.name)) {
            return true;
        }
        return false;
    }

    updateFileList = async (files) => {
        var filesArr = Array.from(files);
        for (const file of filesArr) {
            var image = window.URL.createObjectURL(file);
            if (file.type.match("video.*")) {
                image = new getImageOfVideo(image, 1, this.videoUpload, [file]);
                image.init();
                continue;
            }

            const elementImagePreview = document.createElement("div");
            elementImagePreview.classList.add(
                "upload__img-box",
                ...this.arrayClass
            );

            elementImagePreview.innerHTML = `<div class="img-bg">
                                                <div class="c-img">
                                                    <img src="${image}" alt="" class="img-fluid">
                                                </div>
                                            </div>`;

            const elementRemovePreview = document.createElement("div");
            elementRemovePreview.classList.add("upload__img-close");
            elementRemovePreview.innerHTML = `<i class="fa-solid fa-xmark"></i>`;
            elementRemovePreview.setAttribute("data-file", file.name);
            elementRemovePreview.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.removeFile(file.name, file.size, file.lastModified);
                window.URL.revokeObjectURL(
                    elementRemovePreview.closest(".img-bg").querySelector("img")
                        .src
                );
                elementRemovePreview.closest(".upload__img-box").remove();
            });
            elementImagePreview
                .querySelector(".img-bg")
                .appendChild(elementRemovePreview);
            if (this.previewImageBox) {
                if (!this.element.hasAttribute("has-file")) {
                    this.element.setAttribute("has-file", true);
                }
                this.previewImageBox.appendChild(elementImagePreview);
            }
        }
    };

    videoUpload = (image, file) => {
        const elementImagePreview = document.createElement("div");
        elementImagePreview.classList.add(
            "upload__img-box",
            ...this.arrayClass
        );
        elementImagePreview.innerHTML = `<div class="img-bg">
                                                <div class="c-img">
                                                    <img src="${image}" alt="" class="img-fluid">
                                                </div>
                                            </div>`;

        const elementRemovePreview = document.createElement("div");
        elementRemovePreview.classList.add("upload__img-close");
        elementRemovePreview.innerHTML = `<i class="fa-solid fa-xmark"></i>`;
        elementRemovePreview.setAttribute("data-file", file.name);
        elementRemovePreview.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.removeFile(file.name, file.size, file.lastModified);
            elementRemovePreview.closest(".upload__img-box").remove();
        });

        const elementPreviewVideo = document.createElement("div");
        elementPreviewVideo.classList.add("update__img-preview");
        elementPreviewVideo.innerHTML = `<i class="fa-solid fa-play"></i>`;

        elementPreviewVideo.addEventListener("click", (e) => {
            e.preventDefault();
            const video = document.createElement("video");
            video.src = window.URL.createObjectURL(file);
        });

        elementImagePreview
            .querySelector(".img-bg")
            .appendChild(elementRemovePreview);
        elementImagePreview.appendChild(elementPreviewVideo);
        if (this.previewImageBox) {
            if (!this.element.hasAttribute("has-file")) {
                this.element.setAttribute("has-file", true);
            }
            this.previewImageBox.appendChild(elementImagePreview);
        }
    };

    videoUploadOld = (image, box) => {
        box.querySelector("img").src = image;
        const elementPreviewVideo = document.createElement("div");
        elementPreviewVideo.classList.add("update__img-preview");
        elementPreviewVideo.innerHTML = `<i class="fa-solid fa-play"></i>`;
        box.appendChild(elementPreviewVideo);
    };

    videoUpload = (image, file) => {
        const elementImagePreview = document.createElement("div");
        elementImagePreview.classList.add(
            "upload__img-box",
            ...this.arrayClass
        );
        elementImagePreview.innerHTML = `<div class="img-bg">
                                                <div class="c-img">
                                                    <img src="${image}" alt="" class="img-fluid">
                                                </div>
                                            </div>`;

        const elementRemovePreview = document.createElement("div");
        elementRemovePreview.classList.add("upload__img-close");
        elementRemovePreview.innerHTML = `<i class="fa-solid fa-xmark"></i>`;
        elementRemovePreview.setAttribute("data-file", file.name);
        elementRemovePreview.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.removeFile(file.name, file.size, file.lastModified);
            elementRemovePreview.closest(".upload__img-box").remove();
        });

        elementImagePreview
            .querySelector(".img-bg")
            .appendChild(elementRemovePreview);
        if (this.previewImageBox) {
            if (!this.element.hasAttribute("has-file")) {
                this.element.setAttribute("has-file", true);
            }
            this.previewImageBox.appendChild(elementImagePreview);
        }
    };

    async pushFileOld() {
        var fileBuffer = new DataTransfer();
        const boxLists =
            this.previewImageBox.querySelectorAll(".upload__img-box");
        for await (const box of boxLists) {
            const img = box.querySelector("img");
            const file = RS.dataURLtoFile(
                img.hasAttribute("data-base64")
                    ? img.getAttribute("data-base64")
                    : img.src,
                img.title
            );

            if (file.type.match("video*")) {
                const image = new getImageOfVideo(
                    window.URL.createObjectURL(file),
                    1,
                    this.videoUploadOld,
                    [box]
                );
                image.init();
            }

            fileBuffer.items.add(file);
            const deleteEl = box.querySelector(".upload__img-close");
            deleteEl.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.removeFile(file.name, file.size, file.lastModified);
                box.remove();
            });
        }
        this.oldFiles = fileBuffer.files;
        this.uploadImageInput.files = this.oldFiles;
        return true;
    }

    removeFile(name, size, lastModified) {
        var fileBuffer = new DataTransfer();
        Array.from(this.uploadImageInput.files)
            .filter(
                (item) =>
                    item.name != name &&
                    item.size != size &&
                    item.lastModified != lastModified
            )
            .forEach((file) => fileBuffer.items.add(file));
        this.oldFiles = fileBuffer.files;
        this.uploadImageInput.files = fileBuffer.files;
        if (
            this.uploadImageInput.files.length == 0 &&
            this.element.hasAttribute("has-file")
        ) {
            this.element.removeAttribute("has-file");
        }
    }
}

// const listImage = formElement.querySelectorAll("[box-list-image]");
// listImage.forEach((element) => {
//     new changeMultipleImage(
//         {
//             element: element,
//             attribute: "gallery-of",
//         },
//         element.hasAttribute("has-file")
//     );
// });

class selectDate {
    constructor(attribute) {
        this.attribute = attribute;
        this.dateSelect(this.attribute);
    }

    dateSelect = (attribute) => {
        const day31 = [1, 3, 5, 7, 8, 10, 12];
        const day30 = [4, 6, 9, 11];
        let firstInit = true;
        const selects = document.querySelectorAll(`[${attribute}]`);
        if (selects.length == 0) return;
        const day = Array.from(selects).find(
            (select) => select.getAttribute(`${attribute}`) == "day"
        );
        const month = Array.from(selects).find(
            (select) => select.getAttribute(`${attribute}`) == "month"
        );
        const year = Array.from(selects).find(
            (select) => select.getAttribute(`${attribute}`) == "year"
        );
        if (firstInit) {
            renderDay(day.value);
            firstInit = false;
        }
        selects.forEach((select) => {
            select.onchange = () => {
                if (select.getAttribute(`${attribute}`) == "day") return;
                renderDay();
            };
        });
        function renderDay(dayChoose = false) {
            const isLeapYear =
                (0 == year.value % 4 && 0 != year.value % 100) ||
                0 == year.value % 400;

            let days = [];
            if (day31.includes(Number(month.value))) {
                days = Array.from(Array(31).keys());
            } else if (day30.includes(Number(month.value))) {
                days = Array.from(Array(30).keys());
            } else {
                days = Array.from(Array(isLeapYear ? 29 : 28).keys());
            }

            let daySelected = day.value;
            if (dayChoose) {
                daySelected = dayChoose;
            }

            day.innerHTML = days
                .map(
                    (i) =>
                        `<option value="${i + 1}" ${
                            i + 1 == daySelected ? "selected" : ""
                        }>${i + 1}</option>`
                )
                .join("");
        }
    };
}
class loadInfinite {
    constructor(options) {
        this.watchEl =
            "element" in options && document.querySelector(options.element);
        if (!this.watchEl) return;
        this.listItem = this.watchEl.previousElementSibling;
        if (this.listItem == null || this.listItem == undefined) return;
        if (typeof XHR == "undefined") {
            alert("Cần thêm thư viện XHR");
            return false;
        }
        this.limit = "limit" in options ? options.limit : Infinity;
        this.page = "page" in options ? options.page : 1;
        this.url = "url" in options && options.url;
        this.method = "method" in options ? options.url : "POST";
        this.key = "key" in options ? options.key : "hasNextPage";
        this.loadCategoryProduct();
    }

    loadCategoryProduct = () => {
        this.noLoad = true;
        const io = new IntersectionObserver((entries) => {
            entries.forEach(async (entry) => {
                if (entry.isIntersecting && this.noLoad) {
                    this.noLoad = !this.noLoad;
                    this.listItem.insertAdjacentHTML(
                        "beforeend",
                        this.styleLoading()
                    );
                    return await XHR.send({
                        url: "tai-khoan/ma-giam-gia",
                        method: "POST",
                        data: {
                            page: this.page,
                        },
                    }).then((res) => {
                        this.listItem
                            .querySelector(".rls-wave--overload")
                            .remove();
                        this.listItem.insertAdjacentHTML("beforeend", res.html);
                        if (!res[this.key] && this.page < this.limit) {
                            this.noLoad = !this.noLoad;
                            this.page++;
                        }
                    });
                }
            });
        });
        io.observe(this.watchEl);
    };

    styleLoading = () => {
        return `<style> .rls-wave--overload{ position: relative; text-align: center; margin-bottom: 30px; } .rsl-wave { font-size: var(--rs-l-size, 2rem); color: var(--rs-l-color, var(--color-main)); display: inline-flex; align-items: center; width: 1.25em; height: 1.25em; } .rsl-wave--icon { display: block; background: currentColor; border-radius: 99px; width: 0.25em; height: 0.25em; margin-right: 0.25em; margin-bottom: -0.25em; -webkit-animation: rsla_wave .56s linear infinite; animation: rsla_wave .56s linear infinite; -webkit-transform: translateY(.0001%); transform: translateY(.0001%); } @-webkit-keyframes rsla_wave { 50% { -webkit-transform: translateY(-0.25em); transform: translateY(-0.25em); } } @keyframes rsla_wave { 50% { -webkit-transform: translateY(-0.25em); transform: translateY(-0.25em); } } .rsl-wave--icon:nth-child(2) { -webkit-animation-delay: -.14s; animation-delay: -.14s; } .rsl-wave--icon:nth-child(3) { -webkit-animation-delay: -.28s; animation-delay: -.28s; margin-right: 0; } </style><div class="rls-wave--overload"><div class="rsl-wave"> <span class="rsl-wave--icon"></span> <span class="rsl-wave--icon"></span> <span class="rsl-wave--icon"></span> </div></div>`;
    };
}
class couterRun {
    constructor(options) {
        this.listCounter =
            "attribute" in options
                ? document.querySelectorAll(`[${options.attribute}]`)
                : [];
        if (this.listCounter.length == 0) return;
        this.show = "show" in options ? options.show : "counter-show";
        this.time = "time" in options ? options.time : 1000;
        this.count = "count" in options ? options.count : 0;
        this.listCount = {};
        this.watchEl = this.listCounter[0];
        this.runAgain = "runAgain" in options ? options.runAgain : false;
        this.isRun = true;
        this.countElement();
    }

    countElement = () => {
        const io = new IntersectionObserver((entries) => {
            entries.forEach(async (entry) => {
                if (entry.isIntersecting && this.isRun) {
                    this.isRun = false;
                    this.listCounter.forEach((item, key) => {
                        this.listCount[key] = this.count;
                        const element = item.querySelector(`[${this.show}]`);
                        let [to, string] = element.innerText.match(/\D+|\d+/g);
                        string = string !== undefined ? string : "";
                        let step = Number(to) / (this.time / 10);
                        let counting = setInterval(() => {
                            this.listCount[key] += step;
                            if (this.listCount[key] > to) {
                                clearInterval(counting);
                                element.innerText = `${to}${string}`;
                                this.isRun = this.runAgain;
                            } else {
                                element.innerText = `${Math.round(
                                    this.listCount[key]
                                )} ${string}`;
                            }
                        });
                    });
                }
            });
        });
        io.observe(this.watchEl);
    };
}
class chooseAddress {
    constructor(element, isEdit = false) {
        this.element = element;
        this.province = this.element.querySelector("[name='province_id']");
        if (!this.province) return;
        this.district = this.element.querySelector("[name='district_id']");
        this.ward = this.element.querySelector("[name='ward_id']");
        this.initTomSelect();
        this.chooseProvince();
        if (isEdit) {
            this.chooseDistrict();
        }
    }

    initTomSelect = () => {
        if (typeof TomSelect != "undefined") {
            new TomSelect(this.province, {
                plugins: ["dropdown_input"],
            });
            new TomSelect(this.district, {
                plugins: ["dropdown_input"],
            });
            new TomSelect(this.ward, {
                plugins: ["dropdown_input"],
            });
        }
    };

    chooseProvince = () => {
        this.province.addEventListener("change", async () => {
            this.district.disabled = false;
            this.resetWard();
            const response = await XHR.send({
                url: "lay-danh-sach-quan-huyen",
                method: "POST",
                data: {
                    province_id: this.province.value,
                },
            });
            this.district.innerHTML = response;
            this.district.disabled = false;
            if (typeof TomSelect != "undefined") {
                this.district.tomselect.clearOptions();
                this.district.tomselect.sync();
                this.district.tomselect.enable();
                this.ward.innerHTML =
                    '<option value="">-- Phường/Xã --</option>';
                this.ward.tomselect.clearOptions();
                this.ward.tomselect.sync();
            }
            this.chooseDistrict();
            VALIDATE_FORM.refresh();
        });
    };

    chooseDistrict = () => {
        this.district.addEventListener("change", async () => {
            this.ward.disabled = true;
            const response = await XHR.send({
                url: "lay-danh-sach-phuong-xa",
                method: "POST",
                data: {
                    district_id: this.district.value,
                },
            });
            this.ward.innerHTML = response;
            this.ward.disabled = false;
            if (typeof TomSelect != "undefined") {
                this.ward.tomselect.clearOptions();
                this.ward.tomselect.sync();
                this.ward.tomselect.enable();
            }
            VALIDATE_FORM.refresh();
        });
    };

    resetWard = async () => {
        this.ward.innerHTML = '<option value="">-- Phường/Xã --</option>';
        this.ward.selectedIndex = 0;
    };
}

const defaultChooseDragImage = {
    loadOld: false,
};
class chooseAndDragImage {
    constructor(element, configs = defaultChooseDragImage) {
        this.selectIndex = null;
        this.applyPosition = [];
        this.loadFileOld = configs.loadFileOld;
        this.configs = { ...defaultChooseDragImage, ...configs };
        this.element = element;
        this.fileList = new DataTransfer();
        this.listImage = this.element.getElementsByClassName("upload");
        this.input = this.element.querySelector("input");
        this.listItems = [];
        this.init();
        if (this.configs.loadOld) {
            this.initFileOld();
        }
    }
    initFileOld = async () => {
        for await (const element of this.listImage) {
            let imagePreview = element.querySelector(".image-preview");
            if (imagePreview) {
                let base64 = imagePreview
                    .getAttribute("style")
                    .replace(`background-image:url(`, "")
                    .replace(/.$/, "");
                let file = RS.dataURLtoFile(
                    base64,
                    imagePreview.getAttribute("title")
                );
                this.fileList.items.add(file);
                let close = element.querySelector(".image-action button");
                if (close) {
                    close.onclick = this.removeItem;
                }
            }
        }
        this.input.files = this.fileList.files;
        this.listItems = await Array.from(this.fileList.files);
    };

    init = () => {
        Array.from(this.listImage).forEach((item) => {
            item.onclick = (e) => {
                this.selectIndex = item.dataset.position;
            };
        });

        this.input.onchange = async (e) => {
            if (e.target.files.length == 0) {
                return (this.input.files = this.fileList.files);
            }

            for (const file of e.target.files) {
                if (file.size > 10240000 * 2) {
                    mySupport.showNotify(
                        100,
                        `Tệp ${file.name}: ${RS.humanFileSize(
                            file.size
                        )} đã vượt quá dung lượng tối đa ${RS.humanFileSize(
                            10240000 * 2
                        )}!`
                    );
                    return (this.input.files = this.fileList.files);
                }

                if (!["image.*"].some((type) => file.type.match(type))) {
                    mySupport.showNotify(
                        100,
                        "File không đúng định dạng Ảnh hoặc Video"
                    );
                    return (this.input.files = this.fileList.files);
                }
            }

            this.fileList = new DataTransfer();

            const newFile = await this.validateFile(e.target.files);

            [...this.listItems, ...newFile].forEach((file) =>
                this.fileList.items.add(file)
            );

            this.input.files = await this.fileList.files;
            this.listItems = await Array.from(this.fileList.files);
            this.pushImage(newFile);
        };
    };

    removeFileOld = async (newFile) => {
        let indexOld = undefined;
        this.listItems.forEach((item, index) => {
            const elementChoose = Array.from(this.listImage)
                .find((item) => item.dataset.position == this.selectIndex)
                .querySelector("label .image-preview");
            if (
                elementChoose &&
                item.name == elementChoose.title &&
                item.size == elementChoose.dataset.size &&
                !newFile.some(
                    (file) => item.name == file.name && item.size == file.size
                )
            ) {
                indexOld = index;
            }
        });
        if (indexOld !== undefined) {
            this.listItems = this.listItems.filter(
                (item, index) => index != indexOld
            );
        }
    };

    pushImage = async (newFile) => {
        let count = 0;
        for await (const file of newFile) {
            const image = window.URL.createObjectURL(file);
            const box = Array.from(this.listImage)
                .find(
                    (item) => item.dataset.position == this.applyPosition[count]
                )
                .querySelector("label");
            const select = document.createElement("div");
            select.className = "image-preview";
            select.title = file.name;
            select.dataset.size = file.size;
            const divAction = document.createElement("div");
            divAction.className = "image-action";
            const removeButton = document.createElement("button");
            removeButton.innerHTML = '<i class="fa-solid fa-trash-can"></i>';
            divAction.append(removeButton);
            select.append(divAction);
            select.setAttribute("style", `background-image:url(${image})`);
            if (box.querySelector(".image-preview")) {
                box.querySelector(".image-preview").remove();
            }
            box.append(select);
            select.onclick = (e) => {
                e.preventDefault();
                e.stopPropagation();
            };

            removeButton.onclick = this.removeItem;
            count++;
        }
    };

    removeItem = (e) => {
        e.preventDefault();
        const itemPreview = e.target.closest(".image-preview");
        this.fileList = new DataTransfer();

        this.listItems = this.listItems.filter(
            (item, index) =>
                item.name != itemPreview.title &&
                itemPreview.dataset.size != item.size
        );

        this.listItems.forEach((item) => this.fileList.items.add(item));
        this.input.files = this.fileList.files;
        console.log(this.input.files);
        itemPreview.remove();
    };

    validateFile = async (listItems) => {
        let newFile = Array.from(listItems);
        await this.removeFileOld(newFile);
        this.applyPosition = [];
        let number = 0;
        newFile.forEach((file) => {
            if (
                this.listItems.some(
                    (item) => item.name == file.name && item.size == file.size
                )
            ) {
                number += 1;
            }
        });
        if (number > 0) {
            eval(`${this.configs.notify}`)(100, `Có ${number} file bị trùng`);
        }
        newFile = newFile.filter((file) => {
            return !this.listItems.some((item) => {
                return item.name == file.name && item.size == file.size;
            });
        });

        let numberFile = 0;

        if (
            this.listItems.length + newFile.length >
            Array.from(this.listImage).length
        ) {
            eval(`${this.configs.notify}`)(
                100,
                `Không thể vượt quá ${this.listImage.length} files`
            );

            // Tình phần đang bị thừa
            numberFile =
                newFile.length -
                (Array.from(this.listImage).length - this.listItems.length);
        }

        // Tìm vị trí hiện tại đã có ảnh để không thêm vào
        var checkPositionHasImage = Array.from(this.listImage).map((item) =>
            item.querySelector(".image-preview") ? true : false
        );

        checkPositionHasImage.forEach((item, index) => {
            if (
                this.selectIndex == index ||
                (index > this.selectIndex && !item)
            ) {
                this.applyPosition.push(index);
            }
        });

        // Nếu độ dài của ảnh lớn hơn - vị trí chọn hiện tại nhỏ hơn số lượng file tải lên thì số file cần bỏ đi bằng số lươn
        if (
            Array.from(this.listImage).length > newFile.length &&
            Array.from(this.listImage).length - this.selectIndex <
                newFile.length
        ) {
            numberFile +=
                newFile.length -
                (Array.from(this.listImage).length - this.selectIndex);
        }
        newFile = newFile.splice(0, newFile.length - numberFile);

        numberFile = 0;
        if (this.applyPosition.length < newFile.length) {
            numberFile = newFile.length - this.applyPosition.length;
        }
        newFile = newFile.splice(0, newFile.length - numberFile);
        return newFile;
    };
}

class Filter {
    constructor(
        attribute,
        elementMain,
        url,
        callBackAfterDone = [],
        method = "POST"
    ) {
        this.elementMain = document.querySelector(elementMain);
        if (!this.elementMain) {
            return false;
        }
        this.elements = document.querySelectorAll(attribute);
        this.data = {};
        this.url = url;
        this.method = method;
        this.arrayCallBack = callBackAfterDone;
        this.init();
    }

    init = async () => {
        for await (const item of this.elements) {
            item.onchange = async (e) => {
                e.preventDefault();
                await this.buildData();
                this.submit();
            };
        }
    };

    buildData = async () => {
        this.data = new FormDataRS().buildData(this.elements, "input");
    };

    submit = async () => {
        try {
            XHR.send({
                url: this.url,
                method: this.method,
                data: this.data,
            })
                .then((res) => {
                    this.elementMain.innerHTML = res;
                    return res;
                })
                .then((res) => {
                    this.arrayCallBack.forEach((callback) => {
                        RS.callFunction(callback);
                    });
                    return true;
                })
                .then((res) => {
                    this.pushLink();
                });
        } catch (error) {}
    };

    pushLink = async () => {
        window.history.pushState(
            null,
            null,
            new FormDataRS().buildLink(this.data, window.location.pathname)
        );
    };
}
