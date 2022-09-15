"use strict";

var VALIDATE_FORM = ((options = {}) => {
    let _colorMain = "#f99f1b";
    let _backgroundMain = "#000000";
    let _typeFile = "image*";
    let _color = _colorMain;
    let _colorBorder = _colorMain;
    let _colorComment = _colorMain;
    let _colorBackground = _backgroundMain;
    let _borderRadius = "4px";
    let _timeLoad = 0;
    let _indexCurrent = null;
    options.rules = [
        isRequired('form[check] input[type="radio"][rules="required"]'),
        isRequired('form[check] input[type="checkbox"][rules="required"]'),
    ];

    var validatorRules = {
        // Kiểm tra bắt buộc nhập
        required: function (selector) {
            if (selector.type == "file") {
                return selector.files.length > 0
                    ? undefined
                    : selector.getAttribute("m-required") ||
                          "Vui lòng chọn ảnh";
            } else {
                return selector.value.trim()
                    ? undefined
                    : selector.getAttribute("m-required") ||
                          "Vui lòng nhập thông tin";
            }
        },
        // Kiểm tra có phải là số
        number: function (selector) {
            var regex = /^[0-9]+$/;
            if (selector.value.trim() == "") {
                return undefined;
            }
            return regex.test(selector.value)
                ? undefined
                : selector.getAttribute("m-number") ||
                      "Vui lòng nhập đúng định dạng số";
        },
        //Kiểm tra có phải email
        email: function (selector) {
            if (selector.value.trim() == "") {
                return undefined;
            }
            var regex =
                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return regex.test(selector.value)
                ? undefined
                : selector.getAttribute("m-email") ||
                      "Vui lòng nhập đúng định dạng email";
        },
        // Độ dài ít nhất
        minLength: function (min) {
            return function (selector) {
                if (selector.value.trim() == "") {
                    return undefined;
                }
                return selector.value.length >= min
                    ? undefined
                    : selector.getAttribute("m-minLength") ||
                          `Vui lòng nhập ít nhất ${min} kí tự`;
            };
        },
        // Độ dài nhiều nhất
        maxLength: function (max) {
            return function (selector) {
                if (selector.value.trim() == "") {
                    return undefined;
                }
                return selector.value.length <= max
                    ? undefined
                    : selector.getAttribute("m-maxLength") ||
                          `Vui lòng nhập tối đa ${max} kí tự`;
            };
        },
        // Số lớn hơn
        min: function (min) {
            return function (selector) {
                if (selector.value.trim() == "") {
                    return undefined;
                }
                return Number(selector.value) >= min
                    ? undefined
                    : selector.getAttribute("m-min") ||
                          `Vui lòng nhập số lớn hơn hoặc bằng ${min}`;
            };
        },
        // Độ dài của file
        fileLength: (length) => {
            return function (selector) {
                return Number(selector.files.length) == length
                    ? undefined
                    : selector.getAttribute("m-max") ||
                          `Vui lòng chọn ${length} ảnh `;
            };
        },
        //Chứng minh nhân dân
        cccd: (selector) => {
            if (selector.value.trim() == "") {
                return undefined;
            }
            var check =
                selector.value.length == 9 || selector.value.length == 12;
            return check
                ? undefined
                : selector.getAttribute("m-cccd") ||
                      `Số CMND/CCCD không chính xác`;
        },
        max: function (max) {
            return function (selector) {
                if (selector.value.trim() == "") {
                    return undefined;
                }
                return Number(selector.value) <= max
                    ? undefined
                    : selector.getAttribute("m-max") ||
                          `Vui lòng nhập số bé hơn hoặc bằng ${max} `;
            };
        },
        same: function (nameSelector, formElement) {
            return function (selector) {
                if (selector.value.trim() == "") {
                    return undefined;
                }
                var selectorElement = formElement.querySelector(
                    `[name="${nameSelector}"]`
                ).value;
                return selector.value === selectorElement
                    ? undefined
                    : selector.getAttribute("m-same") ||
                          "Mật khẩu không giống nhau";
            };
        },
        different: function (nameSelector, formElement) {
            return function (selector) {
                var selectorElement = formElement.querySelector(
                    `[name="${nameSelector}"]`
                ).value;
                return selector.value !== selectorElement
                    ? undefined
                    : selector.getAttribute("m-different") ||
                          "Mật khẩu không được giống nhau";
            };
        },
        phoneOrEmail: function (selector) {
            let isPhone = /(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b/;
            var value = selector.value.trim();
            if (isPhone.test(value)) {
                var valueSelector = value.length >= 10;
            } else {
                var isEmail =
                    /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                var valueSelector = isEmail.test(value);
            }
            return valueSelector
                ? undefined
                : selector.getAttribute("m-phoneOrEmail") ||
                      "Không đúng định dạng email hoặc số điện thoại";
        },
        string: function (selector) {
            var isString =
                /^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\W|_]+$/;
            return isString.test(selector.value.trim())
                ? undefined
                : selector.getAttribute("m-string") ||
                      "Không đúng định dạng chữ viết";
        },
        phone: function (selector) {
            let isPhone = /(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b/;
            selector.getAttribute("rules");
            var check = isPhone.test(selector.value);
            return check
                ? undefined
                : selector.getAttribute("m-phone") ||
                      "Vui lòng nhập đúng định dạng số điện thoại";
        },
        regex: function (regex) {
            return function (selector) {
                return RegExp(regex).test(selector.value)
                    ? undefined
                    : selector.getAttribute("m-regex") ||
                          `Không đúng định dạng quy định`;
            };
        },
    };

    function setStype() {
        var cssAnimation = document.createElement("style");
        cssAnimation.type = "text/css";
        var keyframes = document.createTextNode(
            `@-webkit-keyframes openErrorMessage {from { opacity:0; transform: translateY(15px) } to{opacity:1; transform: translateY(5px)} }
            .r-error-message[type="absolute"]::before{
                content: '';
                border-width: 3px 5px;
                position: absolute;
                border-color: transparent transparent ${_colorBackground} transparent;
                border-style: solid;
                left: 25%;
                bottom: 100%;
                transform: translateX(-50%);
            }`
        );
        cssAnimation.appendChild(keyframes);
        document.getElementsByTagName("head")[0].appendChild(cssAnimation);
    }

    function setConfig(options) {
        _color = options.color || _colorMain;
        _colorBorder = options.colorBorder || _colorMain;
        _colorComment = options.colorComment || _colorMain;
        _colorBackground = options.colorBackground || _backgroundMain;
        _borderRadius = options.borderRadius || "";
        _timeLoad = options.timeLoad || 0;
        _typeFile = options.typeFile || _typeFile;
    }

    function isRequired(selector) {
        return {
            selector: selector,
            check: function (value, selector) {
                let message = selector.getAttribute("m-required")
                    ? selector.getAttribute("m-required")
                    : "Vui lòng nhập trường này";
                return value ? undefined : message;
            },
        };
    }

    function getParent(element, selector) {
        while (element.parentElement) {
            if (element.parentElement.matches(selector)) {
                return element.parentElement;
            }
            element = element.parentElement;
        }
    }

    function callFunction(func, options = []) {
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
    }

    function insertAfter(referenceNode, newNode) {
        referenceNode.parentNode.insertBefore(
            newNode,
            referenceNode.nextSibling
        );
    }

    function appendError(referenceNode, newNode) {
        referenceNode.appendChild(newNode);
    }

    function sleep(ms) {
        return new Promise((resolve) => {
            setTimeout(resolve, ms);
        });
    }

    function init(formLive = null) {
        let isPassLiveForm = true;
        const formElements =
            formLive !== null
                ? [formLive]
                : document.querySelectorAll(".form-validate");
        Array.from(formElements).forEach((formElement) => {
            var formRules = {};
            var fileList = [];
            var selectorRules = [];
            var errorSelector = [];
            var gallery = formElement.hasAttribute("gallery") ? true : false;
            var nameInputFile;
            var isAbsolute = formElement.hasAttribute("absolute")
                ? true
                : false;
            var isClear = formElement.hasAttribute("clear") ? true : false;
            var hasFuncPlus = formElement.hasAttribute("plus")
                ? formElement.getAttribute("plus")
                : null;

            function validateRadioCheckBox(rule, isSubmit) {
                var rules = selectorRules[rule.selector];
                var selector = formElement.querySelector(rule.selector);
                var errorMessage;
                var parentElement = false;
                if (formElement.hasAttribute("parent")) {
                    parentElement = getParent(
                        selector,
                        formElement.getAttribute("parent")
                    );
                }
                for (var i in rules) {
                    switch (selector.type) {
                        case "radio":
                        case "checkbox":
                            errorMessage = rules[i](
                                formElement.querySelector(
                                    rule.selector + ":checked"
                                ),
                                parentElement ? parentElement : selector
                            );
                            break;
                        default:
                            errorMessage = rules[i](selector.value);
                    }
                    if (errorMessage) break;
                }
                if (errorMessage) {
                    if (parentElement) {
                        actionHasParentElement(
                            parentElement,
                            errorMessage,
                            selector,
                            isSubmit
                        );
                    } else {
                        actionNoParentElement(errorMessage, selector, isSubmit);
                    }
                } else {
                    handleClearError({ target: selector });
                }
                return !errorMessage;
            }

            function configErrorElement(errorElement) {
                errorElement.className = "r-error-message";
                Object.assign(errorElement.style, {
                    pointerEvents: "none",
                    color: _color,
                    display: "block",
                    fontSize: "12px",
                    paddingBottom: "8px",
                    textAlign: "left",
                    zIndex: 2,
                    animation: "0.3s openErrorMessage ease-in-out forwards",
                });
            }

            function actionHasParentElement(
                parentElement,
                errorMessage,
                selector,
                isSubmit = true
            ) {
                var errorElement = document.createElement("span");
                configErrorElement(errorElement);
                if (isAbsolute && !selector.hasAttribute("no-absolute")) {
                    styleElementErrorAbsolute(parentElement, errorElement);
                }
                if (errorMessage) {
                    if (isSubmit) {
                        errorSelector.push(selector);
                        errorSelector[0].focus();
                    }
                    errorElement.innerHTML = errorMessage;
                    switch (selector.type) {
                        case "checkbox":
                        case "radio":
                            const domErrorElement =
                                parentElement.nextElementSibling;
                            if (
                                domErrorElement === null ||
                                domErrorElement.className !== "r-error-message"
                            ) {
                                insertAfter(parentElement, errorElement);
                            }
                            break;
                        default:
                            if (
                                !parentElement.querySelector(".r-error-message")
                            ) {
                                appendError(parentElement, errorElement);
                                if (parentElement.hasAttribute("no-border"))
                                    return;
                                parentElement.style.border =
                                    "1px solid " + _colorBorder;
                            }
                            break;
                    }
                }
            }

            function styleElementErrorAbsolute(selector, error) {
                error.setAttribute("type", "absolute");
                Object.assign(error.style, {
                    position: "absolute",
                    padding: "5px 10px",
                    fontWeight: "bold",
                    borderRadius: _borderRadius,
                    background: _colorBackground,
                    maxWidth: "80%",
                    wordBreak: "break-word",
                });
                const parentSelector = selector.parentElement;
                const style = getComputedStyle(parentSelector);
                const checkPosition = style.position;
                if (
                    selector.type == ("select-one" || "select-multiple") &&
                    checkPosition == "relative"
                ) {
                    Object.assign(error.style, {
                        top:
                            (selector.clientHeight >= 5
                                ? selector.clientHeight
                                : parentSelector.clientHeight) + "px",
                        left: 0,
                    });
                }
                if (checkPosition !== "relative") {
                    Object.assign(error.style, {
                        top:
                            (selector.offsetTop !== 0
                                ? selector.offsetTop
                                : parentSelector.offsetTop) +
                            (selector.clientHeight !== 0
                                ? selector.clientHeight
                                : parentSelector.clientHeight) +
                            "px",
                        left:
                            (selector.offsetLeft !== 0
                                ? selector.offsetLeft
                                : parentSelector.offsetLeft) + "px",
                    });
                }

                if (selector.type === "radio") {
                    Object.assign(error.style, {
                        top:
                            parentSelector.offsetTop +
                            parentSelector.clientHeight +
                            10 +
                            "px",
                        left: parentSelector.offsetLeft + "px",
                    });
                }
            }

            function actionNoParentElement(
                errorMessage,
                selector,
                isSubmit = true
            ) {
                var errorElement = document.createElement("span");
                configErrorElement(errorElement);
                if (isAbsolute && !selector.hasAttribute("no-absolute")) {
                    styleElementErrorAbsolute(selector, errorElement);
                }
                if (errorMessage) {
                    if (isSubmit) {
                        errorSelector.push(selector);
                        errorSelector[0].focus();
                    }
                    errorElement.innerHTML = errorMessage;
                    switch (selector.type) {
                        case "checkbox":
                        case "radio":
                            const parentMaxSelector =
                                selector.parentElement.parentElement;
                            if (
                                parentMaxSelector.nextElementSibling == null ||
                                !parentMaxSelector.nextElementSibling.classList.contains(
                                    "r-error-message"
                                )
                            ) {
                                insertAfter(parentMaxSelector, errorElement);
                            }
                            break;
                        default:
                            if (
                                selector.nextElementSibling == undefined ||
                                (selector.nextElementSibling !== undefined &&
                                    selector.nextElementSibling.className !==
                                        "r-error-message")
                            ) {
                                insertAfter(selector, errorElement);
                                if (selector.hasAttribute("no-border")) return;
                                selector.style.border =
                                    "1px solid " + _colorBorder;
                            }
                            break;
                    }
                }
            }

            function handleClearError(event) {
                const selector = event.target;
                var parentElement = false;
                if (formElement.hasAttribute("parent")) {
                    parentElement = getParent(
                        selector,
                        formElement.getAttribute("parent")
                    );
                }
                switch (selector.type) {
                    case "checkbox":
                    case "radio":
                        if (!parentElement) {
                            var errorElement =
                                selector.parentElement.parentElement
                                    .nextElementSibling;
                            if (
                                errorElement !== undefined &&
                                errorElement !== null &&
                                errorElement.className === "r-error-message"
                            ) {
                                removeStyle(errorElement);
                            }
                        } else {
                            const errorElement =
                                parentElement.nextElementSibling;
                            if (
                                errorElement !== null &&
                                errorElement !== undefined &&
                                errorElement.classList.contains(
                                    "r-error-message"
                                )
                            ) {
                                removeStyle(errorElement);
                            }
                        }
                        break;
                    case "select-one":
                        if (selector.value == "") {
                            handleValidateFocus(event);
                            break;
                        }
                    default:
                        if (
                            !parentElement &&
                            selector.nextElementSibling !== null &&
                            selector.nextElementSibling !== undefined &&
                            selector.nextElementSibling.className ===
                                "r-error-message"
                        ) {
                            selector.style.removeProperty("border");
                            removeStyle(selector.nextElementSibling);
                        } else if (
                            parentElement &&
                            parentElement.querySelector(".r-error-message")
                        ) {
                            var parentElement = getParent(
                                selector,
                                formElement.getAttribute("parent")
                            );
                            removeStyle(
                                parentElement.querySelector(".r-error-message")
                            );
                            parentElement.style.removeProperty("border");
                        }
                        break;
                }
            }

            function removeStyle(element) {
                element.animate(
                    [{ opacity: 0, transform: "translateY(10px)" }],
                    {
                        duration: 300,
                        fill: "forwards",
                    }
                ).onfinish = function () {
                    element.remove();
                };
            }

            function handleValidateFocus(event) {
                var selector = event.target;
                var rules = formRules[selector.name];
                var errorMessage;
                for (var rule of rules) {
                    if (selector.value.length == 0) break;
                    errorMessage = rule(selector);
                    if (errorMessage) {
                        break;
                    }
                }
                var parentElement = false;
                if (formElement.hasAttribute("parent")) {
                    parentElement = getParent(
                        selector,
                        formElement.getAttribute("parent")
                    );
                }
                if (parentElement) {
                    actionHasParentElement(
                        parentElement,
                        errorMessage,
                        selector,
                        false
                    );
                } else {
                    actionNoParentElement(errorMessage, selector, false);
                }

                return !errorMessage;
            }

            function checkValidateNow(elements) {
                let isValid = true;
                isAbsolute = true;
                for (var selector of elements) {
                    if (!handleSubmitValidate({ target: selector })) {
                        isValid = false;
                    }
                }
                return isValid;
            }

            function handleSubmitValidate(event) {
                var selector = event.target;
                var rules = formRules[selector.name];
                var errorMessage;
                for (var rule of rules) {
                    errorMessage = rule(selector);
                    if (errorMessage) {
                        break;
                    }
                }
                var parentElement = false;
                if (formElement.hasAttribute("parent")) {
                    parentElement = getParent(
                        selector,
                        formElement.getAttribute("parent")
                    );
                }
                if (parentElement) {
                    actionHasParentElement(
                        parentElement,
                        errorMessage,
                        selector,
                        true
                    );
                } else {
                    actionNoParentElement(errorMessage, selector, true);
                }
                return !errorMessage;
            }

            function changeImage() {
                if (gallery) {
                    const list = setListItem();
                    let galleryPhotoInput =
                        formElement.querySelector("[input-file]");
                    let placeGallery =
                        formElement.querySelector("[data-gallery]");
                    nameInputFile = galleryPhotoInput.name;
                    galleryPhotoInput.onchange = function (e) {
                        pushFileList(placeGallery, list, e.target.files);
                        galleryPhotoInput.value = null;
                    };
                }
            }

            async function pushFileList(placeGallery, list, files) {
                var isChange = false;
                await Array.from(files).forEach(async function (file) {
                    if (file.type.match(_typeFile)) {
                        isChange = true;
                        fileList.push(file);
                        var length = fileList.length;
                        var li = document.createElement("li");
                        var divImage = document.createElement("div");
                        var img = document.createElement("img");
                        img.src = window.URL.createObjectURL(file);
                        var button = document.createElement("button");
                        button.dataset.length = length - 1;
                        elementButton(button);
                        elementDivPreview(divImage);
                        const divAction = await elementDivAction(
                            placeGallery,
                            list,
                            button,
                            li,
                            img,
                            file
                        );
                        elementLi(li);
                        divImage.appendChild(img);
                        li.appendChild(divImage);
                        await li.appendChild(divAction);
                        await list.appendChild(li);
                        placeGallery.appendChild(list);
                        await onLightbox(list);
                    }
                });

                if (isChange) {
                    elementGallery(placeGallery, list);
                }
            }

            function onLightbox(list) {
                const images = list.querySelectorAll("li");
                images.forEach(function (imageElement, index) {
                    imageElement.onclick = function (event) {
                        event.stopPropagation();
                        _indexCurrent = index;
                        zoomImg(imageElement, images);
                    };
                });
            }

            function zoomImg(selector, galleries) {
                const img = selector.querySelector("img");
                var gallery = document.createElement("div");
                var imgElement = document.createElement("div");
                var closeLightBoxButton = document.createElement("button");
                var buttonLeft = document.createElement("button");
                var buttonRight = document.createElement("button");
                styleButtonChange(buttonLeft, "left", galleries, imgElement);
                styleButtonChange(buttonRight, "right", galleries, imgElement);

                gallery.className = "img-preview";
                imgElement.className = "img-preview__bg";
                buttonAction(
                    closeLightBoxButton,
                    gallery,
                    imgElement,
                    selector
                );

                elementImage(imgElement, img.src, gallery);
                galleryImage(gallery, selector);
                gallery.appendChild(imgElement);
                gallery.appendChild(closeLightBoxButton);
                gallery.appendChild(buttonLeft);
                gallery.appendChild(buttonRight);
                document.querySelector("body").appendChild(gallery);
            }

            function styleButtonChange(
                button,
                position,
                galleries,
                imgElement
            ) {
                Object.assign(button.style, {
                    position: "absolute",
                    top: "50%",
                    transition: "all 300ms ease-out",
                    cursor: "pointer",
                    height: "25px",
                    width: "25px",
                    borderBottom: "4px solid white",
                    borderLeft: "4px solid white",
                    borderTop: "none",
                    background: "transparent",
                    borderRight: "none",
                });

                button.onmousemove = function () {
                    button.style.filter = "drop-shadow(4px 2px 3px white)";
                };

                button.onmouseleave = function () {
                    button.style.filter = "inherit";
                };

                if (position == "right") {
                    button.style.right = "16px";
                    button.style.transform = "translateY(-50%) rotate(-135deg)";
                } else {
                    button.style.left = "16px";
                    button.style.transform = "translateY(-50%) rotate(45deg)";
                }

                button.onclick = function (e) {
                    e.stopPropagation();
                    if (position == "right") {
                        _indexCurrent++;
                        _indexCurrent =
                            _indexCurrent > galleries.length - 1
                                ? 0
                                : _indexCurrent;
                    } else {
                        _indexCurrent--;
                        _indexCurrent =
                            _indexCurrent < 0
                                ? galleries.length - 1
                                : _indexCurrent;
                    }
                    imgElement.style.backgroundImage = `url(${
                        galleries[_indexCurrent].querySelector("img").src
                    })`;
                };
            }

            function buttonAction(button, gallery, imgElement, selector) {
                button.innerHTML = "🗙";
                Object.assign(button.style, {
                    position: "absolute",
                    color: "white",
                    background: "#01010150",
                    zIndex: 1,
                    padding: "6px 10px",
                    fontSize: "24px",
                    fontWeight: "bold",
                    cursor: "pointer",
                    top: "15px",
                    right: "15px",
                    border: "none",
                    borderRadius: _borderRadius,
                });
                button.onmousemove = function () {
                    button.animate(
                        [
                            {
                                backgroundColor: _colorBorder,
                                boxShadow:
                                    "0.2px 0.2px 6px 0.2px " + _colorBorder,
                            },
                        ],
                        {
                            duration: 400,
                            fill: "forwards",
                        }
                    );
                };
                button.onmouseleave = function () {
                    button.animate(
                        [
                            {
                                boxShadow: "none",
                                color: "white",
                                background: "#01010150",
                            },
                        ],
                        {
                            duration: 400,
                            fill: "forwards",
                        }
                    );
                };
                button.onclick = function () {
                    const imageAnimate = imgElement.animate(
                        [{ opacity: 1 }, { opacity: 0 }],
                        {
                            duration: 300,
                            fill: "forwards",
                        }
                    );
                    imageAnimate.onfinish = function () {
                        const galleryAnimate = gallery.animate(
                            [{ opacity: 1 }, { opacity: 0 }],
                            {
                                duration: 300,
                            }
                        );
                        galleryAnimate.onfinish = function () {
                            gallery.remove();
                            selector.style.pointerEvents = "all";
                        };
                    };
                };
            }

            function elementImage(imgElement, img) {
                Object.assign(imgElement.style, {
                    width: "50%",
                    paddingBottom: "28%",
                    borderRadius: _borderRadius,
                    height: "0",
                    backgroundRepeat: "no-repeat",
                    backgroundSize: "contain",
                    backgroundPosition: "center",
                    transition: "box-shadow 0.1s, transform 0.1s",
                    margin: "0 auto",
                    backgroundOrigin: "border-box",
                    transition: "transform 0.1s ease-out,box-shadow 0.2s",
                    backgroundImage: `url(${img})`,
                    cursor: "grab",
                });

                styleHoverImage(imgElement);

                imgElement.src = img;
                imgElement.addClass;
                imgElement.onclick = function (e) {
                    e.stopPropagation();
                };
            }

            function styleHoverImage(imgElement) {
                imgElement.onmousemove = (e) => {
                    const height = imgElement.clientHeight;
                    const width = imgElement.clientWidth;
                    const layerX = e.layerX;
                    const layerY = e.layerY;
                    const yRotation = -8 * ((layerX - width / 2) / width);
                    const xRotation = 8 * ((layerY - height / 2) / height);
                    const string =
                        "perspective(500px) scale(0.95) rotateX(" +
                        xRotation +
                        "deg) rotateY(" +
                        yRotation +
                        "deg)";
                    imgElement.style.transform = string;
                };

                imgElement.onmouseleave = function () {
                    imgElement.style.transform = "scale(1)";
                };
            }

            function galleryImage(gallery, selector) {
                Object.assign(gallery.style, {
                    position: "fixed",
                    background: "#01010199",
                    width: "100%",
                    height: "100%",
                    display: "flex",
                    alignItems: "center",
                    justifyContent: "center",
                    top: 0,
                    left: 0,
                    zIndex: 1060,
                });

                gallery.animate([{ opacity: 0 }, { opacity: 1 }], {
                    duration: 300,
                    iterations: 1,
                });

                gallery.onclick = function () {
                    selector.style.pointerEvents = "all";
                    const milisecond = 300;
                    gallery.animate([{ opacity: 1 }, { opacity: 0 }], {
                        duration: milisecond,
                        iterations: 1,
                    });
                    setTimeout(() => {
                        gallery.remove();
                    }, milisecond - 100);
                };
            }

            function setListItem() {
                var list = document.createElement("ul");
                elementList(list);
                return list;
            }

            function elementList(list) {
                var styleElement = document.createElement("style");
                styleElement.appendChild(
                    document.createTextNode(
                        "div ::-webkit-scrollbar {display:none;-webkit-appearance: none}"
                    )
                );

                Object.assign(list.style, {
                    display: "grid",
                    listStyle: "none",
                    gridAutoFlow: "column",
                    padding: "16px",
                    overflow: "auto",
                    gridGap: "16px",
                    gridAutoColumns: "120px",
                });
                list.append(styleElement);
                dragList(list);
            }

            function dragList(slider) {
                let isDown = false;
                let startX;
                let scrollLeft;
                let selectTarget;
                slider.addEventListener("mousedown", (e) => {
                    e.preventDefault();
                    selectTarget = e.target;
                    isDown = true;
                    slider.style.cursor = "grap";
                    startX = e.pageX - slider.offsetLeft;
                    scrollLeft = slider.scrollLeft;
                });

                slider.addEventListener("mouseleave", (e) => {
                    e.preventDefault();
                    isDown = false;
                    swapLink(isDown);
                });

                slider.addEventListener("mouseup", (e) => {
                    e.preventDefault();
                    isDown = false;
                    swapLink(isDown);
                });

                slider.addEventListener("mousemove", (e) => {
                    if (!isDown) return;
                    swapLink(isDown);
                    e.preventDefault();
                    const x = e.pageX - slider.offsetLeft;
                    const walk = (x - startX) * 1; //scroll-fast
                    slider.scrollLeft = scrollLeft - walk;
                });

                function swapLink(drag) {
                    if (drag) {
                        if (
                            selectTarget.hasAttribute("href") &&
                            !selectTarget.hasAttribute("data-href")
                        ) {
                            selectTarget.setAttribute(
                                "data-href",
                                selectTarget.getAttribute("href")
                            );
                            selectTarget.href = "javascript:void(0)";
                        }
                    } else {
                        setTimeout(() => {
                            if (
                                selectTarget instanceof Element &&
                                selectTarget.hasAttribute("data-href")
                            ) {
                                selectTarget.setAttribute(
                                    "href",
                                    selectTarget.getAttribute("data-href")
                                );
                                selectTarget.removeAttribute("data-href");
                            }
                        }, 100);
                    }
                }
            }

            function elementGallery(gallery, list) {
                Object.assign(gallery.style, {
                    border: "2px dashed " + _colorComment,
                    margin: "12px 0",
                    padding: 0,
                    cursor: "pointer",
                    borderRadius: _borderRadius,
                    transition: "all 0.3s ease-in-out",
                });

                gallery.ondragover = function () {
                    this.style.borderColor = "blue";
                    this.style.opacity = 0.5;
                    return false;
                };

                gallery.ondragleave = function () {
                    this.style.borderColor = _colorBorder;
                    this.style.opacity = 1;
                    return false;
                };

                gallery.ondragend = function (e) {
                    e.preventDefault();
                    return false;
                };

                gallery.ondrop = function (e) {
                    e.preventDefault();
                    this.style.borderColor = "green";
                    this.style.opacity = 1;
                    pushFileList(gallery, list, e.dataTransfer.files);
                };

                gallery.onclick = function () {
                    formElement.querySelector("[input-file]").click();
                };
                gallery.innerHTML = "";
            }

            function elementDivPreview(divImage) {
                Object.assign(divImage.style, {
                    position: "relative",
                    display: "block",
                    borderRadius: _borderRadius,
                    paddingBottom: "100%",
                    boxShadow: "0 0 3px #00000030",
                });
            }

            async function elementDivAction(
                placeGallery,
                list,
                button,
                li,
                img,
                file
            ) {
                const divAction = document.createElement("div");
                elementImg(img);
                Object.assign(divAction.style, {
                    position: "absolute",
                    top: 0,
                    left: 0,
                    width: "100%",
                    height: "100%",
                    display: "flex",
                    alignItems: "center",
                    justifyContent: "center",
                    flexWrap: "wrap",
                    flexDirection: "column",
                    transition: "all 0.3s",
                });
                var name = file.name;
                var size = Math.ceil(file.size / 1024);
                var pName = document.createElement("p");
                var pSize = document.createElement("p");

                pName.innerText = name;
                if (size > 1000) {
                    pSize.innerText = Number(size / 1000).toFixed(1) + " MB";
                } else {
                    pSize.innerText = size + " KB";
                }
                elementName(pName);
                elementSize(pSize);

                var progress = document.createElement("div");
                var progressLength = document.createElement("div");
                progress.className = "img-progress";

                Object.assign(progress.style, {
                    width: "100px",
                    height: "16px",
                    position: "absolute",
                    top: "50%",
                    left: "50%",
                    transform: "translate(-50%, -50%)",
                    borderRadius: _borderRadius,
                    overflow: "hidden",
                });

                Object.assign(progressLength.style, {
                    background: "white",
                    height: "100%",
                    width: 0,
                });

                progress.appendChild(progressLength);
                divAction.appendChild(progress);

                const progressAnimateFirst = await progressLength.animate(
                    [
                        {
                            width: 0,
                        },
                        {
                            width: "100%",
                        },
                    ],
                    {
                        duration: size,
                        fill: "forwards",
                    }
                );

                progressAnimateFirst.onfinish = function () {
                    const progressAnimateTwo = progressLength.animate(
                        [
                            {
                                opacity: 0,
                            },
                        ],
                        {
                            duration: 300,
                            fill: "forwards",
                        }
                    );

                    progressAnimateTwo.onfinish = function () {
                        progress.remove();
                        afterShowImage(li, button, pName, pSize, img);
                        divAction.appendChild(button);
                        divAction.appendChild(pName);
                        divAction.appendChild(pSize);
                        button.onclick = function (e) {
                            e.stopPropagation();
                            const length = button.dataset.length;
                            fileList[length] = null;
                            button.closest("li").remove();
                            updateGallery(placeGallery, fileList);
                            onLightbox(list);
                        };
                    };
                };

                return divAction;
            }

            function updateGallery(placeGallery, fileList) {
                if (fileList.filter((file) => file !== null).length == 0) {
                    placeGallery.removeAttribute("style");
                }
            }

            function afterShowImage(li, button, pName, pSize, img) {
                img.style.filter = "blur(0px)";
                li.style.cursor = "zoom-in";
                li.onmouseover = () => {
                    button.style.opacity = 1;
                    pName.style.opacity = 1;
                    pSize.style.opacity = 1;
                    img.style.filter = "blur(2px)";
                };
                li.onmouseleave = () => {
                    button.style.opacity = 0;
                    pName.style.opacity = 0;
                    pSize.style.opacity = 0;
                    img.style.filter = "blur(0px)";
                };
                // li.onclick = (e) => {
                // 	e.stopPropagation();
                // 	li.style.pointerEvents = "none";
                // 	zoomImg(img.src, li);
                // };
                pName.onmouseover = function () {
                    Object.assign(pName.style, {
                        background: "white",
                    });
                };
                pName.onmouseleave = function () {
                    Object.assign(pName.style, {
                        background: "#ffffff9e",
                    });
                };
                pSize.onmouseover = function () {
                    Object.assign(pSize.style, {
                        background: "white",
                    });
                };
                pSize.onmouseleave = function () {
                    Object.assign(pSize.style, {
                        background: "#ffffff9e",
                    });
                };
            }

            function elementName(name) {
                name.title = name.innerText;
                Object.assign(name.style, {
                    width: "75%",
                    borderRadius: _borderRadius,
                    marginTop: "24px",
                    padding: "4px 10px",
                    background: "#ffffff9e",
                    color: "#0e0e0e",
                    opacity: 0,
                    marginBottom: "8px",
                    fontSize: "12px",
                    display: "block",
                    overflow: "hidden",
                    textAlign: "center",
                    textOverflow: "ellipsis",
                    whiteSpace: "nowrap",
                    transition: "all 0.3s",
                });
            }

            function elementSize(size) {
                Object.assign(size.style, {
                    width: "75%",
                    borderRadius: _borderRadius,
                    padding: "4px 10px",
                    fontSize: "12px",
                    background: "#ffffff9e",
                    textAlign: "center",
                    color: "#0e0e0e",
                    opacity: 0,
                    display: "-webkit-box",
                    webkitLineClamp: 1,
                    webkitBoxOrient: "vertical",
                    transition: "all 0.3s",
                });
            }

            function elementLi(li) {
                Object.assign(li.style, {
                    position: "relative",
                    display: "inline-block",
                    verticalAlign: "top",
                });
            }

            function elementImg(img) {
                Object.assign(img.style, {
                    position: "absolute",
                    inset: 0,
                    width: "100%",
                    height: "100%",
                    objectFit: "cover",
                    filter: "blur(1px)",
                    transition: "all 0.3s",
                    borderRadius: _borderRadius,
                });
            }

            function elementButton(button) {
                button.innerHTML = "🗙";
                button.type = "button";
                Object.assign(button.style, {
                    position: "absolute",
                    right: "8px",
                    top: "8px",
                    cursor: "pointer",
                    background: _colorComment,
                    border: "1px solid " + _colorComment,
                    boxShadow: "0.2px 0.2px 6px 0.2px " + _colorComment,
                    color: "white",
                    height: "20px",
                    width: "20px",
                    fontWeight: "bold",
                    fontSize: "8px",
                    opacity: "0",
                    borderRadius: _borderRadius,
                    transition: "all 0.3s",
                    padding: 0,
                    margin: 0,
                });

                button.onmouseover = function () {
                    Object.assign(button.style, {
                        border: "1px solid " + _colorComment,
                        boxShadow: "0.2px 0.2px 6px 0.2px " + _colorComment,
                        transform: "scale(0.95)",
                    });
                };
                button.onmouseleave = function () {
                    Object.assign(button.style, {
                        border: "1px solid " + _colorComment,
                        boxShadow: "0.2px 0.2px 6px 0.2px " + _colorComment,
                    });
                };
            }

            function clearForm() {
                const inputs = formElement.querySelectorAll("[name]");
                inputs.forEach(function (element) {
                    switch (element.type) {
                        case "checkbox":
                        case "radio":
                            element.checked = false;
                            break;
                        case "select-one":
                            element.selectedIndex = 0;
                            break;
                        case "hidden":
                            break;
                        default:
                            element.value = "";
                            break;
                    }
                });
            }

            function getStyle(element, property) {
                return window
                    .getComputedStyle(element, null)
                    .getPropertyValue(`'${property}'`);
            }

            function submitForm(data, formElement) {
                var check = formElement.dataset.success;
                if (!check) {
                    return formElement.submit();
                }
                var dataOuter = formElement.hasAttribute("data-outer")
                    ? formElement.getAttribute("data-outer")
                    : false;
                if (dataOuter) {
                    data = callFunction(dataOuter, [data]);
                }
                var method = formElement.getAttribute("method");
                var url = formElement.getAttribute("action");
                var button = formElement.querySelector('button[type="submit"]');

                var ajax = new XMLHttpRequest();
                ajax.open(method, url, true);
                ajax.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                ajax.onreadystatechange = function () {
                    if (ajax.readyState === XMLHttpRequest.DONE) {
                        var status = ajax.status;
                        if (status === 0 || (status >= 200 && status < 400)) {
                            const dataResponse = JSON.parse(ajax.responseText);
                            if (
                                isClear &&
                                "code" in dataResponse &&
                                dataResponse.code == 200
                            ) {
                                const boxGallery = formElement.querySelectorAll( "[data-gallery]" );
                                if ( boxGallery.length > 0 && boxGallery[0].querySelectorAll("ul")  ) {
                                    fileList = [];
                                    if(boxGallery[0].querySelector( "ul" )){
                                        boxGallery[0].querySelector( "ul" ).innerHTML = "";
                                    }
                                    boxGallery[0].removeAttribute("style");
                                }
                                clearForm();
                            }
                            callFunction(check, [
                                dataResponse,
                                data,
                                formElement,
                            ]);

                            button.removeAttribute("style");
                            if (button.hasAttribute("style-old")) {
                                button.setAttribute(
                                    "style",
                                    button.getAttribute("style-old")
                                );
                            }
                            button.innerHTML =
                                button.getAttribute("content-old");

                            return setTimeout(() => {
                                button.disabled = false;
                            }, 1000);
                        } else {
                            console.log(ajax);
                        }
                    }
                };

                var formData = new FormData();
                if (gallery) {
                    Array.from(
                        fileList.filter((file) => file !== null)
                    ).forEach(function (file) {
                        formData.append(nameInputFile + "[]", file);
                    });
                } else if (data.image) {
                    Array.from(data.image).forEach(function (file) {
                        formData.append(nameInputFile + "[]", file);
                    });
                }
                for (const [key, value] of Object.entries(data)) {
                    if (
                        key.indexOf("[]") > -1 ||
                        (value instanceof Array && value.length > 1)
                    ) {
                        value.forEach(function (val) {
                            formData.append(
                                key.indexOf("[]") > -1 ? key : key + "[]",
                                val
                            );
                        });
                    } else if (value instanceof Array) {
                        formData.append(key, value);
                    } else if (nameInputFile !== key || !gallery) {
                        formData.append(key, value);
                    }
                }

                if (button) {
                    buttonFormBeforeSubmit(button);
                }

                ajax.send(formData);
            }

            function buttonFormBeforeSubmit(button) {
                if (button.getAttribute("style")) {
                    button.setAttribute(
                        "style-old",
                        button.getAttribute("style")
                    );
                }

                const buttonRect = button.getBoundingClientRect();
                Object.assign(button.style, {
                    width: `${buttonRect.width}px`,
                    height: `${buttonRect.height}px`,
                    position: `relative`,
                    display: "inline-block",
                });

                if (button.hasAttribute("content")) {
                    button.setAttribute(
                        "content-old",
                        button.getAttribute("content")
                    );
                } else {
                    button.setAttribute("content-old", button.innerHTML);
                }
                button.disabled = true;
                const colorButton = getStyle(button, "color");
                setTimeout(() => {
                    button.innerHTML = `<div class="r-s-loader"></div><style>.r-s-loader{position:absolute;left:50%;top:50%;border:5px solid ${colorButton};border-radius:50%;border-top:5px solid ${colorButton};border-bottom:5px solid ${colorButton};border-left:5px solid transparent;border-right:5px solid transparent;width:${
                        buttonRect.height - 12
                    }px;height:${
                        buttonRect.height - 12
                    }px;-webkit-animation:spin 2s linear infinite;animation:spin 2s linear infinite}@-webkit-keyframes spin{0%{-webkit-transform:translate(-50%,-50%) rotate(0)}100%{-webkit-transform:translate(-50%,-50%) rotate(360deg)}}@keyframes spin{0%{transform:translate(-50%,-50%) rotate(0)}100%{transform:translate(-50%,-50%) rotate(360deg)}}</style>`;
                }, _timeLoad);

                return button;
            }

            if (formElement) {
                var elements = formElement.querySelectorAll(
                    "[rules]:not([disabled])"
                );
                for (var selector of elements) {
                    var rules = selector.getAttribute("rules").split("||");
                    for (var rule of rules) {
                        var ruleInfo;
                        var isRuleHasValue = rule.includes(":");
                        if (isRuleHasValue) {
                            ruleInfo = rule.split(":");
                            rule = ruleInfo[0];
                        }
                        var ruleFunc = validatorRules[rule];
                        if (rule.includes("regex")) {
                            ruleFunc = validatorRules["regex"];
                        }

                        if (isRuleHasValue) {
                            var ruleFunc = ruleFunc(ruleInfo[1], formElement);
                        }

                        if (Array.isArray(formRules[selector.name])) {
                            formRules[selector.name].push(ruleFunc);
                        } else {
                            formRules[selector.name] = [ruleFunc];
                        }
                    }
                    //  Lắng nghe sự kiên validate (blur,change,click)
                    selector.addEventListener("blur", handleValidateFocus);
                    selector.addEventListener("input", handleClearError);
                    selector.addEventListener("click", handleClearError);
                    selector.addEventListener("change", handleClearError);
                }

                formElement.onsubmit = formSubmit;

                async function formSubmit(event) {
                    event.preventDefault();
                    var isValid = true;
                    var isValidCheck = true;
                    for (var selector of elements) {
                        if (!handleSubmitValidate({ target: selector })) {
                            isValid = false;
                        }
                    }
                    if (Object.keys(options).length != 0) {
                        options.rules.forEach(function (rule) {
                            var inputElements = formElement.querySelectorAll(
                                rule.selector
                            );
                            if (inputElements.length > 0) {
                                isValidCheck = validateRadioCheckBox(
                                    rule,
                                    true
                                );
                                if (!isValidCheck) {
                                    isValidCheck = false;
                                }
                            }
                        });
                    }

                    if (
                        (hasFuncPlus == null ||
                            (await callFunction(hasFuncPlus, [formElement]))) &&
                        isValid &&
                        isValidCheck
                    ) {
                        var enableInputs = formElement.querySelectorAll(
                            "[name]:not([disabled])"
                        );
                        var formValues = Array.from(enableInputs).reduce(
                            function (values, input) {
                                switch (input.type) {
                                    case "radio":
                                        var radioChecked =
                                            formElement.querySelector(
                                                `input[name="${input.name}"]:checked`
                                            );
                                        if (radioChecked !== null) {
                                            values[input.name] =
                                                radioChecked.value;
                                        } else {
                                            values[input.name] = "";
                                        }
                                        break;
                                    case "checkbox":
                                        if (input.matches(":checked")) {
                                            if (
                                                !Array.isArray(
                                                    values[input.name]
                                                )
                                            ) {
                                                values[input.name] = [];
                                            }
                                            values[input.name].push(
                                                input.value
                                            );
                                        } else if (
                                            values[input.name] == undefined
                                        ) {
                                            values[input.name] = "";
                                        }
                                        break;
                                    case "file":
                                        if (input.name.indexOf("[]") > -1) {
                                            if (
                                                !Array.isArray(
                                                    values[input.name]
                                                )
                                            ) {
                                                values[input.name] = [];
                                            }
                                            values[input.name].push(
                                                ...input.files
                                            );
                                        } else {
                                            if (input.files.length > 0) {
                                                values[input.name] =
                                                    input.files[0];
                                            } else {
                                                values[input.name] = "";
                                            }
                                        }
                                        nameInputFile = input.name;
                                        break;
                                    case "select-multiple":
                                        const selectOptions =
                                            input.querySelectorAll(
                                                "option:checked"
                                            );
                                        selectOptions.forEach(function (
                                            optionEl
                                        ) {
                                            if (
                                                !Array.isArray(
                                                    values[input.name]
                                                )
                                            ) {
                                                values[input.name] = [];
                                            }
                                            values[input.name].push(
                                                optionEl.value
                                            );
                                        });
                                        break;
                                    default:
                                        if (input.name.indexOf("[]") > -1) {
                                            if (
                                                !Array.isArray(
                                                    values[input.name]
                                                )
                                            ) {
                                                values[input.name] = [];
                                            }
                                            values[input.name].push(
                                                input.value
                                            );
                                        } else {
                                            values[input.name] = input.value;
                                        }
                                        break;
                                }
                                return values;
                            },
                            {}
                        );
                        submitForm(formValues, formElement);
                    } else {
                        errorSelector = [];
                    }
                }

                if (Object.keys(options).length != 0) {
                    options.rules.forEach(function (rule) {
                        // Lưu lại các rules cho mỗi input
                        if (Array.isArray(selectorRules[rule.selector])) {
                            selectorRules[rule.selector].push(rule.check);
                        } else {
                            selectorRules[rule.selector] = [rule.check];
                        }
                        var inputElements = formElement.querySelectorAll(
                            rule.selector
                        );
                        Array.from(inputElements).forEach(function (
                            inputElement
                        ) {
                            // Xử lý trường hợp blur khỏi input
                            inputElement.onchange = function () {
                                validateRadioCheckBox(rule, false);
                            };
                        });
                    });
                }
            }

            function clearErrorElement() {
                formElement
                    .querySelectorAll(".r-error-message")
                    .forEach((e) => removeStyle(e));
            }

            if (formLive !== null) {
                isPassLiveForm = checkValidateNow(elements);
            } else {
                return {
                    start: (function () {
                        changeImage();
                        clearErrorElement();
                    })(),
                };
            }
        });
        setStype();
        return isPassLiveForm;
    }

    return {
        load: (function () {
            init();
        })(),
        setConfig: function (options) {
            setConfig(options);
        },
        checkForm: function (form) {
            return init(form);
        },
        refresh: function () {
            return init();
        },
    };
})();
