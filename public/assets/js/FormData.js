class FormDataRS {
    constructor(attribute = "", noCheckAndNoValue = false) {
        this.attribute = attribute;
        this.noCheckAndNoValue = noCheckAndNoValue;
    }

    getObjectData() {
        return this.buildData(document.querySelectorAll(`[${this.attribute}]`));
    }

    getFormData(objectData) {
        const formData = new FormData();
        for (const [key, value] of Object.entries(objectData)) {
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
            } else {
                formData.append(key, value);
            }
        }

        if (token.length > 0) {
            formData.append(token[0], token[1]);
        }
        return formData;
    }

    /**
     * customInput
     * 1. 'attribute' => Attribute áp dụng đầu class
     * 2. 'input' => name của input có sẵn
     * default. 'tùy chọn' => Attribute bất kỳ
     * */

    buildData(enableInputs, customAttribute = "attribute") {
        var dataValues = Array.from(enableInputs).reduce((values, input) => {
            if (!input.value && !this.noCheckAndNoValue) return values;
            let nameInput;

            switch (customAttribute) {
                case "attribute":
                    nameInput = input.getAttribute(this.attribute);
                    break;
                case "input":
                    nameInput = input.name;
                    break;
                default:
                    nameInput = input.getAttribute(customAttribute);
                    break;
            }

            switch (input.type) {
                case "radio":
                    var radioChecked = input.parentElement.querySelector(
                        `input[name="${input.name}"]:checked`
                    );
                    if (radioChecked !== null) {
                        values[nameInput] = radioChecked.value;
                    }
                    break;
                case "checkbox":
                    if (
                        !values[nameInput] &&
                        (input.matches(":checked") || this.noCheckAndNoValue)
                    ) {
                        values[nameInput] = input.value;
                        break;
                    }

                    if (!input.matches(":checked")) {
                        break;
                    }

                    if (input.matches(":checked") || this.noCheckAndNoValue) {
                        if (!Array.isArray(values[nameInput])) {
                            values[nameInput] = [values[nameInput]];
                        }
                        values[nameInput].push(input.value);
                    } else if (values[nameInput] === undefined) {
                        values[nameInput] = "";
                    }
                    break;
                case "file":
                    if (nameInput.indexOf("[]") > -1) {
                        if (!Array.isArray(values[nameInput])) {
                            values[nameInput] = [];
                        }
                        values[nameInput].push(...input.files);
                    } else {
                        if (input.files.length > 0) {
                            values[nameInput] = input.files[0];
                        } else {
                            values[nameInput] = "";
                        }
                    }
                    break;
                case "select-multiple":
                    const selectOptions =
                        input.querySelectorAll("option:checked");
                    selectOptions.forEach(function (optionEl) {
                        if (!Array.isArray(values[nameInput])) {
                            values[nameInput] = [];
                        }
                        values[nameInput].push(optionEl.value);
                    });
                    break;
                default:
                    if (nameInput.indexOf("[]") > -1) {
                        if (!Array.isArray(values[nameInput])) {
                            values[nameInput] = [];
                        }
                        values[nameInput].push(input.value);
                    } else {
                        values[nameInput] = input.value;
                    }
                    break;
            }
            return values;
        }, {});
        return dataValues;
    }

    clearData(inputs) {
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

    buildStringData(objectData) {
        const stringData = "?";
        for (const [key, value] of Object.entries(objectData)) {
            stringData += `${key}=${value}`;
        }
    }

    buildLink(formData, pathCustom = undefined) {
        var params = Object.entries(formData)
            .map(([key, value]) => {
                if (Array.isArray(value) && value.length > 1) {
                    return value.map((item) => `${key}=${item}`).join("&");
                } else {
                    return `${key}=${value}`;
                }
            })
            .join("&");

        let fullLink = "";
        if (pathCustom !== undefined) {
            fullLink =
                window.location.origin +
                pathCustom +
                (params == "" ? "" : "?" + params);
        } else {
            var link = window.location.origin + window.location.pathname;
            fullLink = params == "" ? link : link + "?" + params;
        }
        return fullLink;
    }
}
