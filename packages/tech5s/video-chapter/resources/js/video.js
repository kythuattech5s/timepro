import getImageOfVideo from "./ImageVideo.js";
import Helper from "./../../../../roniejisa/scripts/assets/js/Helper.js";

class ListVideoChaptr {
    constructor(table) {
        this.table = table;
        this.nameTable = this.table.getAttribute("tech5s-video-chapter");
        this.fields = JSON.parse(this.table.getAttribute("field-list"));
        this.inputRaw = this.table.querySelector(
            `textarea[name="${this.nameTable}"]`
        );
        this.init();
        this.addItem();
        this.styleInput = "w-full px-2 py-1 border";
        this.changeDataImageOld();
        this.updateAll();
    }

    init = () => {
        this.listMain = this.table.querySelector("[list-items]");
        this.listItems = this.listMain.querySelectorAll("[item]");
        this.btnAddItem = this.table.querySelector("[add-item]");
        this.btnAddItem.onclick = this.addHTML;
    };

    addHTML = async (e) => {
        const item = document.createElement("div");
        item.className = "col-span-1 border border-[#212529] p-2 relative";
        item.setAttribute("item", "");
        for await (const field of this.fields) {
            const id = this.nameTable + "-" + this.makeId(6);
            item.innerHTML += this.getHTMLType(field, id);
        }
        const close = document.createElement("button");
        close.type = "button";
        close.innerHTML = '<i class="fa fa-times" aria-hidden="true"></i>';
        close.classList =
            "absolute top-1 right-1 bg-orange-500 text-white h-10 w-10";
        close.setAttribute("remove-item", "");
        close.onclick = () => {
            item.remove();
            this.updateAll();
        };
        item.append(close);
        this.listMain.append(item);
        this.addEventChange();

        //Xóa file
        this.removeFile();
    };

    addEventChange = () => {
        this.listMain.querySelectorAll("[data-name]").forEach((input) => {
            input.onchange = () => {
                this.updateAll();
            };
        });
    };

    removeFile = () => {
        this.btnRemoveFiles = this.listMain.querySelectorAll("[remove-file]");
        this.btnRemoveFiles.forEach((button) => {
            button.onclick = () => {
                const id = button.getAttribute("remove-file");
                const div = document.querySelector(`[data-id="${id}"]`);
                const img = div.querySelector("img");
                img.src = "/admin/images/noimage.png";
                if (img.hasAttribute("data-blob")) {
                    const blob = img.dataset.blob;
                    window.URL.revokeObjectURL(blob);
                    img.removeAttribute("data-blob");
                }
                const input = div.querySelector(`input[id="${id}"]`);
                input.value = "";
                this.updateAll();
            };
        });
    };

    updateAll = () => {
        this.raw = [];
        this.listMain.querySelectorAll("[item]").forEach((item) => {
            const dataFields = item.querySelectorAll("[data-name]");
            const dataItem = {};
            dataFields.forEach((data) => {
                dataItem[data.dataset.name] = data.value;
            });
            this.raw.push(dataItem);
        });
        this.inputRaw.innerHTML = JSON.stringify(this.raw);
    };

    changeDataImageOld = async () => {
        this.raw = [];

        const listVideo = this.listMain.querySelectorAll(
            "[item] [video-content]"
        );
        for (let index = 0; index < listVideo.length; index++) {
            if (
                listVideo[index].hasAttribute("data-path") &&
                listVideo[index].getAttribute("data-path") != ""
            ) {
                const coponentImg = listVideo[index].closest("[data-id]");
                const input = coponentImg.querySelector("input");
                const video = document.createElement("video");
                video.innerHTML = `<source src="${listVideo[index].getAttribute(
                    "data-path"
                )}" type='video/mp4' />`;
                video.onloadedmetadata = function () {
                    input.nextElementSibling.value = video.duration;
                };
                input.dispatchEvent(new Event("change"));
            }
        }

        this.removeItem();
        this.removeFile();
        this.addEventChange();
    };

    removeItem() {
        this.btnRemoveFiles = this.listMain.querySelectorAll("[remove-item]");
        this.btnRemoveFiles.forEach((button) => {
            button.onclick = () => {
                const item = button.closest("[item]");
                const img = item.querySelector("img");
                if (img && img.hasAttribute("data-blob")) {
                    window.URL.revokeObjectURL(img.dataset.blob);
                }
                item.remove();
                this.updateAll();
            };
        });
    }

    getHTMLType = (field, id) => {
        let html;
        switch (field.type) {
            case "text":
                html = `
                    <div>
                        <label htmlFor="">${field.label}</label>
                        <input type="text" class="${this.styleInput}" placeholder="${field.placeholder}" data-name="${field.name}"/>
                    </div>
                `;
                break;
            case "file":
                html = `
                    <div data-id="${id}">
                        <label htmlFor="">${field.label}</label>
                        <input type="hidden" id="${id}" data-name="${field.name}" />
                        <a href="/esystem/media/view?istiny=${id}&callback=VIDEO_CHAPTER.callbackFile" class="iframe-btn">
                            <p class="disabled" file-name="${id}"></p>
                        </a>
                        <div class="mt-3 gap-2 grid grid-cols-2">
                            <a class="text-center text-white p-2 w-full bg-blue-600 col-span-1 iframe-btn" href="/esystem/media/view?istiny=${id}&callback=VIDEO_CHAPTER.callbackFile" type="button">${field.placeholder}</a>
                            <a class="text-center text-white p-2 w-full bg-red-600 col-span-1" href="javascript:void(0)" remove-file="${id}" >Xóa</a>
                        </div>
                    </div>
                `;
                break;
            case "video":
                html = `
                    <div data-id="${id}">
                        <label htmlFor="">${field.label}</label>
                        <input type="hidden" id="${id}" data-name="${field.name}" />
                        <input type="hidden" data-name="duration"/>
                        <a href="/esystem/media/view?istiny=${id}&callback=VIDEO_CHAPTER.callbackVideo" class="iframe-btn">
                            <p class="pointer-events-none">Vui lòng chọn video</p>
                        </a>
                        <div class="mt-3 gap-2 grid grid-cols-2">
                            <a class="text-center text-white p-2 w-full bg-blue-600 col-span-1 iframe-btn" href="/esystem/media/view?istiny=${id}&callback=VIDEO_CHAPTER.callbackVideo" type="button">${field.placeholder}</a>
                            <a class="text-center text-white p-2 w-full bg-red-600 col-span-1" href="javascript:void(0)" remove-file="${id}" >Xóa</a>
                        </div>
                    </div>
                `;
                break;
            case "select":
                html = `
                <label htmlFor="">${field.label}</label>
                <select data-name="${field.name}" class="${this.styleInput}">
                    ${field.options
                        .map((option) => {
                            return `<option value="${option.value}">${option.name}</option>`;
                        })
                        .join("")}
                </select>
                `;
                break;
            case "image":
                html = `
                    <div data-id="${id}">
                        <label htmlFor="">${field.label}</label>
                        <input type="hidden" id="${id}" data-name="${field.name}" />
                        <a href="/esystem/media/view?istiny=${id}&callback=VIDEO_CHAPTER.callbackImage" class="iframe-btn">
                            <img src="/admin/images/noimage.png" alt="" class="w-full max-h-[120px] object-cover"/>
                        </a>
                        <div class="mt-3 gap-2 grid grid-cols-2">
                            <a class="text-center text-white p-2 w-full bg-blue-600 col-span-1 iframe-btn" href="/esystem/media/view?istiny=${id}&callback=VIDEO_CHAPTER.callbackImage" type="button">${field.placeholder}</a>
                            <a class="text-center text-white p-2 w-full bg-red-600 col-span-1" href="javascript:void(0)" remove-file="${id}" >Xóa</a>
                        </div>
                    </div>
                `;
                break;
            case "hidden":
                html = `<input type="hidden" data-name="${field.name}">`;
                break;
            case "":
                break;
        }

        return html;
    };

    addItem = () => {};

    makeId = (length) => {
        var result = "";
        var characters =
            "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(
                Math.floor(Math.random() * charactersLength)
            );
        }
        return result;
    };
}

window.addEventListener("DOMContentLoaded", function () {
    (() => {
        var init = () => {
            const tables = document.querySelectorAll("[tech5s-video-chapter]");
            tables.forEach((table, index) => {
                new ListVideoChaptr(table);
            });
        };

        return {
            load: (() => {
                init();
            })(),
        };
    })();
});
window["VIDEO_CHAPTER"] = (() => {
    return {
        callbackVideo: (items, id) => {
            const media = items[0];
            if (media.file_name.indexOf(".mp4") < 0) {
                alert("Không đúng định dạng video");
                return false;
            }
            const urlOrigin = window.location.origin + "/";
            const video = document.createElement("video");

            video.innerHTML = `<source src="${
                urlOrigin + media.path + media.file_name
            }" type='video/mp4' />`;
            video.onloadedmetadata = function () {
                const div = document.querySelector(`[data-id="${id}"]`);
                div.querySelector("p").innerHTML = media.file_name;
                const input = div.querySelector(`input[id="${id}"]`);
                input.nextElementSibling.value = video.duration;
                input.value = JSON.stringify(media);
                input.dispatchEvent(new Event("change"));
            };
        },
        callbackImage: (items, id) => {
            const media = items[0];
            const div = document.querySelector(`[data-id="${id}"]`);
            const urlOrigin = window.location.origin + "/";
            const img = div.querySelector("img");
            console.log(img);
            const input = div.querySelector(`input[id="${id}"]`);
            img.src = urlOrigin + media.path + media.file_name;
            input.value = JSON.stringify(media);
            input.dispatchEvent(new Event("change"));
        },
        callbackFile: (items, id) => {
            const media = items[0];
            const div = document.querySelector(`[data-id="${id}"]`);
            const p = div.querySelector("p");
            const input = div.querySelector(`input[id="${id}"]`);
            p.innerHTML = media.file_name;
            input.value = JSON.stringify(media);
            input.dispatchEvent(new Event("change"));
        },
    };
})();
