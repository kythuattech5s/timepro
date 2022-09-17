const Helper = {
    convertDate: function (str) {
        var date = new Date(str),
            mnth = ("0" + (date.getMonth() + 1)).slice(-2),
            day = ("0" + date.getDate()).slice(-2);
        return [date.getFullYear(), mnth, day].join("-");
    },
    number_format: (number, oneChar = ",", twoChar = ".") => {
        return number != ""
            ? Intl.NumberFormat().format(number).replaceAll(oneChar, twoChar)
            : "";
    },
    limitString: (input, limit = 10) => {
        let string = input.value;
        if (string.split("").length >= limit) {
            string = string.substring(0, limit);
        }
        return string;
    },
    inputNumber(input, min = 0, max = Infinity) {
        const numberOrNull = input.value.trim() == "" ? null : input.value;
        if (numberOrNull == null) {
            return (input.value = "");
        } else {
            const n = numberOrNull.toString().replaceAll(/[^\d]/g, "");
            if (n >= min && n <= max) {
                input.value = input.value;
            } else {
                input.value = n.slice(0, -1);
            }
        }
        return input.value;
    },
    nonAccentVietnamese: (
        keyword,
        options = {
            removeCharacter: false,
            upperCase: false,
            removeNumber: false,
            removeString: false,
        }
    ) => {
        const defaultOption = {
            removeCharacter: false,
            upperCase: false,
            removeNumber: false,
            removeString: false,
        };
        options = { ...defaultOption, ...options };

        keyword = keyword.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
        keyword = keyword.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        keyword = keyword.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        keyword = keyword.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        keyword = keyword.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        keyword = keyword.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        keyword = keyword.replace(/đ/g, "d");
        keyword = keyword.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, ""); // Huyền sắc hỏi ngã nặng
        keyword = keyword.replace(/\u02C6|\u0306|\u031B/g, ""); // Â, Ê, Ă, Ơ, Ư

        keyword = options.removeCharacter
            ? keyword.replace(/[^\w\s]/gi, "")
            : keyword;

        keyword = options.upperCase ? keyword.toUpperCase() : keyword;

        keyword = options.removeNumber
            ? keyword.replace(/[0-9]/g, "")
            : keyword;

        keyword = options.removeString
            ? keyword.replace(/[^a-zA-Z]/gi, "")
            : keyword;
        return keyword;
    },
    siblings: (elem) => {
        //Tạo mảng rỗng
        let siblings = [];
        siblings.push(elem);

        //  Kiểm tra nếu không có cha thì return lại
        if (!elem.parentNode) {
            return siblings;
        }
        // Lấy ra phần tử đầu của mảng để đệ quy
        let sibling = elem.parentNode.firstElementChild;

        // Vòng lặp lấy ra đến khi null
        do {
            // Thêm element sibling vào mảng
            if (sibling != elem) {
                siblings.push(sibling);
            }
        } while ((sibling = sibling.nextElementSibling));

        return siblings;
    },
    removeDuplicateTwoArrayObject(arrayMain, arraySub, attr) {
        // Remove Object Sub In arrayMain
        let newArray = arrayMain.filter((objectMain) => {
            return !arraySub.some((objectSub) => {
                return objectMain[attr] == objectSub[attr];
            });
        });
        // Get Attribute Main RemoveAttributeSub
        const getAttributeMain = newArray.map((item) => item[attr]);
        // Remove Duplicate
        newArray = newArray.filter(
            (item, index) => !getAttributeMain.includes(item[attr], index + 1)
        );
        return newArray;
    },
    removeSkeleton: () => {
        const seleton = document.querySelectorAll("[skeleton-loading]");
        setTimeout(() => {
            seleton.forEach((item) => item.removeAttribute("skeleton-loading"));
        }, 1000);
    },
    dataURLtoFile(base64, filename) {
        var arr = base64.split(",");
        if (arr[0] == "") return "";
        var mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]),
            n = bstr.length,
            u8arr = new Uint8Array(n);

        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }

        return new File([u8arr], filename, {
            type: mime,
        });
    },
    clearDataForm: (form) => {
        const inputs = form.querySelectorAll("[name]");
        inputs.forEach(function (element) {
            switch (element.type) {
                case "checkbox":
                case "radio":
                    element.checked = false;
                    break;
                case "select-one":
                    if (element.hasAttribute("clear-option")) {
                        element.innerHTML = `<option value="">${element.getAttribute(
                            "clear-option"
                        )}</option>`;
                    }
                    element.selectedIndex = 0;
                    break;
                case "hidden":
                    break;
                default:
                    element.value = "";
                    break;
            }
        });
    },
    openNewWindow: (
        link,
        options = {
            with: 400,
            height: 400,
        }
    ) => {
        window.open(
            link,
            "_blank",
            `toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=${options.with}, height=${options.height}`
        );
    },
    callFunction: (func, options = []) => {
        try {
            var arrayFunc = func.split(".");
            if (
                arrayFunc.length === 1 &&
                null != window[arrayFunc[0]] &&
                typeof window[arrayFunc[0]] === "function"
            ) {
                return (
                    null != window[arrayFunc[0]] &&
                    typeof window[arrayFunc[0]] === "function" &&
                    window[arrayFunc[0]](...options)
                );
            } else if (arrayFunc.length === 2) {
                var obj = arrayFunc[0];
                func = arrayFunc[1];
                const classEval =
                    typeof eval(`${obj}`) === "object"
                        ? eval(`${obj}`)
                        : eval(`new ${obj}()`);
                if (
                    typeof classEval === "object" &&
                    typeof classEval[func] === "function"
                ) {
                    return (
                        typeof classEval[func] === "function" &&
                        classEval[func](...options)
                    );
                } else if (
                    window[obj] === "object" &&
                    typeof window[obj][func] === "function"
                ) {
                    return (
                        window[obj] === "object" &&
                        typeof window[obj][func] === "function" &&
                        window[obj][func](...options)
                    );
                }
            }
        } catch (err) {
            console.log(err);
            alert(
                "Sửa lại data-success, Chưa đúng định dạng Object Function hoặc Class Function"
            );
        }
    },
    humanFileSize(B, i = true) {
        var e = i ? 1e3 : 1024;
        if (Math.abs(B) < e) return B + " B";
        var a = i
                ? ["kB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"]
                : ["KiB", "MiB", "GiB", "TiB", "PiB", "EiB", "ZiB", "YiB"],
            t = -1;
        do (B /= e), ++t;
        while (Math.abs(B) >= e && t < a.length - 1);
        return B.toFixed(1) + " " + a[t];
    },
    copyToClipboard: (text) => {
        var textarea = document.createElement("textarea");
        textarea.textContent = text;
        document.body.appendChild(textarea);

        var selection = document.getSelection();
        var range = document.createRange();
        range.selectNode(textarea);
        selection.removeAllRanges();
        selection.addRange(range);
        document.execCommand("copy");
        selection.removeAllRanges();
        document.body.removeChild(textarea);
    },
    toHHMMSS: (sec_num) => {
        var hours = Math.floor(sec_num / 3600);
        var minutes = Math.floor((sec_num - hours * 3600) / 60);
        var seconds = sec_num - hours * 3600 - minutes * 60;

        if (hours < 10) {
            hours = "0" + hours;
        }
        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        if (seconds < 10) {
            seconds =
                "0" + Math.floor(Math.round(seconds * 10) / 10).toFixed(0);
        }

        if (Number(hours) > 0 && Number(minutes) > 0) {
            return hours + ":" + minutes + ":" + seconds;
        } else {
            return minutes + ":" + seconds;
        }
    },
};

export default Helper;
