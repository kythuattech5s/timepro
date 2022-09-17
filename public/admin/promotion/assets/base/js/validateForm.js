"use strict";

var VALIDATE_FORM = ((options = {}) => {
    let _colorMain = "#ff8888";
    let _backgroundMain = "#3b3b3b";
    let _color = _colorMain;
    let _colorBorder = _colorMain;
    let _colorBackground = _backgroundMain;
    let _borderRadius = "4px";
    let _timeLoad = 0;
    options.rules = [
        isRequired('form[check] input[type="radio"][rules="required"]'),
        isRequired('form[check] input[type="checkbox"][rules="required"]'),
    ];

    var validatorRules = {
        required: function (selector) {
            if (
                selector.type == "file" &&
                selector.getAttribute("input-file") == ""
            ) {
                const form = getParent(selector, "form");
                const gallery = form.querySelector("[data-gallery]");
                const image = gallery.querySelectorAll("li");
                return image.length > 0
                    ? undefined
                    : selector.getAttribute("m-required") ||
                          "Vui lòng nhập trường này";
            } else if (selector.hasAttribute("gallery")) {
                const form = getParent(selector, "form");
                const gallery = form.querySelector("div[class^='preview_img']");
                const img = gallery.querySelector("img");
                return img.src.trim !== ""
                    ? undefined
                    : selector.getAttribute("m-required") ||
                          "Vui lòng nhập trường này";
            } else {
                return selector.value.trim()
                    ? undefined
                    : selector.getAttribute("m-required") ||
                          "Vui lòng nhập trường này";
            }
        },
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

            return isPhone.test(selector.value)
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
        var arrayFunc = func.split(".");
        if (arrayFunc.length === 1) {
            var func = arrayFunc[0];
            return (
                null != window[func] &&
                typeof window[func] === "function" &&
                window[func](...options)
            );
        } else if (arrayFunc.length === 2) {
            var obj = arrayFunc[0];
            func = arrayFunc[1];
            return (
                window[obj] != null &&
                typeof window[obj] === "object" &&
                null != window[obj][func] &&
                typeof window[obj][func] === "function" &&
                window[obj][func](...options)
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
                                clearForm();
                            }
                            callFunction(check, [
                                dataResponse,
                                data,
                                formElement,
                            ]);
                        }
                    }
                    resetButton(button);
                };

                var formData = new FormData();
                if (data.image) {
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

            function resetButton(button) {
                button.removeAttribute("style");
                if (button.hasAttribute("style-old")) {
                    button.setAttribute(
                        "style",
                        button.getAttribute("style-old")
                    );
                }
                button.innerHTML = button.getAttribute("content-old");

                button.disabled = false;
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
                    selector.onblur = handleValidateFocus;
                    selector.oninput = handleClearError;
                    selector.onclick = handleClearError;
                    selector.onchange = handleClearError;
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
