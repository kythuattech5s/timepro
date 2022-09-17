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

    changeDataImageOld = () => {
        this.raw = [];
        this.listMain.querySelectorAll("[item] img").forEach((img) => {
            const coponentImg = img.closest("[data-id]");
            const id = coponentImg.dataset.id;
            const media = JSON.parse(coponentImg.querySelector("input").value);
            var request = new XMLHttpRequest();
            request.open("GET", img.src, true);
            request.responseType = "blob";
            request.onload = function () {
                var reader = new FileReader();
                reader.readAsDataURL(request.response);
                reader.onload = function (e) {
                    const base64 = e.target.result;
                    let mimeType = base64.match(/[^:/]\w+(?=;|,)/)[0];
                    const path = Helper.dataURLtoFile(base64, mimeType);
                    const blob = window.URL.createObjectURL(path);
                    img.setAttribute("data-blob", blob);
                    new getImageOfVideo(blob, 1, videoUpload, [
                        id,
                        media,
                    ]).init();
                };
            };
            request.send();
        });
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
                if (img.hasAttribute("data-blob")) {
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
                        <input type="hidden" data-name="duration"/>
                        <a href="/esystem/media/view?istiny=${id}&callback=VIDEO_CHAPTER.callbackFile" class="iframe-btn">
                            <img src="/admin/images/noimage.png" alt="" class="w-full h-auto" />
                        </a>
                        <div class="mt-3 gap-2 grid grid-cols-2">
                            <a class="text-center text-white p-2 w-full bg-blue-600 col-span-1 iframe-btn" href="/esystem/media/view?istiny=${id}&callback=VIDEO_CHAPTER.callbackFile" type="button">${field.placeholder}</a>
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
        callbackFile: (items, id) => {
            const media = items[0];
            const img = document.querySelector(`[data-id="${id}"] img`);
            var request = new XMLHttpRequest();
            const urlOrigin = window.location.origin + "/";
            request.open("GET", urlOrigin + media.path + media.file_name, true);

            request.responseType = "blob";
            request.onload = function () {
                var reader = new FileReader();
                reader.readAsDataURL(request.response);
                reader.onload = function (e) {
                    const base64 = e.target.result;
                    let mimeType = base64.match(/[^:/]\w+(?=;|,)/)[0];
                    const path = Helper.dataURLtoFile(base64, mimeType);
                    const blob = window.URL.createObjectURL(path);
                    img.setAttribute("data-blob", blob);
                    new getImageOfVideo(blob, 1, videoUpload, [
                        id,
                        media,
                    ]).init();
                };
            };
            request.send();
        },
    };
})();
const videoUpload = (base64img, id, jsonFile, duration) => {
    const div = document.querySelector(`[data-id="${id}"]`);
    const image = div.querySelector("img");
    const input = div.querySelector(`input[id="${id}"]`);
    console.log(input.nextElementSibling);
    input.nextElementSibling.value = Helper.toHHMMSS(duration);
    input.value = JSON.stringify(jsonFile);
    image.src = base64img;
    input.dispatchEvent(new Event("change"));
};