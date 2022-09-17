class FormDataRS {
    constructor(attribute, noCheckAndNoValue = false) {
        this.attribute = attribute;
        this.noCheckAndNoValue = noCheckAndNoValue;
    }

    getObjectData() {
        return this.getDataValues(
            document.querySelectorAll(`[${this.attribute}]`)
        );
    }

    getFormData() {
        const data = this.getDataValues(
            document.querySelectorAll(`[${this.attribute}]`)
        );
        const formData = new FormData();
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
            } else {
                formData.append(key, value);
            }
        }

        if (token.length > 0) {
            formData.append(token[0], token[1]);
        }
        return formData;
    }

    getDataValues(enableInputs) {
        var dataValues = Array.from(enableInputs).reduce((values, input) => {
            if (!input.value && !this.noCheckAndNoValue) return values;
            const nameInput = input.getAttribute(this.attribute);
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
}
