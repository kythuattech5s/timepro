//Sử dụng đối với table
"use strict";

class checkBoxTable {
    constructor(options = {}) {
        this.isStart = true;
        this.getCount =
            "getCount" in options ? options.getCount : "[m-checkbox-count]";
        this.mainSelector =
            "mainSelector" in options ? options.mainSelector : "m-checkbox";
        this.allSelector =
            "allSelector" in options ? options.allSelector : "[c-multiple]";
        this.parentSelector =
            "parentSelector" in options
                ? options.parentSelector
                : "[c-parent-single]";
        this.singleSelector =
            "singleSelector" in options ? options.singleSelector : "[c-single]";
        this.inputPasteData =
            "inputSaveData" in options
                ? options.inputSaveData
                : "textarea[c-data]";

        this.inputGetData =
            "inputGetData" in options ? options.inputGetData : "data-checked";
        this.attributeMainCompare = "[data-checked-main]";
        this.attributeForParentSelector =
            "attributeForParentSelector" in options
                ? options.attributeForParentSelector
                : "[c-check-item]";
    }
    clear() {
        this.isStart = true;
    }
    refresh() {
        var clearStorage = () => {
            if (this.isStart) {
                const mutipleCheckboxAll = document.querySelectorAll(
                    `[${this.mainSelector}]`
                );
                mutipleCheckboxAll.forEach((item) => {
                    localStorage.removeItem(
                        item.getAttribute(this.mainSelector).toUpperCase()
                    );
                    const dataOld = item.querySelector(this.inputPasteData);
                    if (dataOld && dataOld.value.trim() !== "") {
                        localStorage.setItem(
                            item.getAttribute(this.mainSelector).toUpperCase(),
                            JSON.stringify(JSON.parse(dataOld.value))
                        );
                    }
                });
            }
            this.isStart = false;
        };

        const mutipleCheckboxAll = document.querySelectorAll(
            `[${this.mainSelector}]`
        );
        mutipleCheckboxAll.forEach((multiple, indexEl) => {
            const main = multiple.querySelector(this.inputPasteData);
            var checkedAll = () => {
                const checkMultipleChild = multiple.querySelectorAll(
                    this.parentSelector
                );
                const checkAll = multiple.querySelector(this.allSelector);
                if (checkAll) {
                    checkAll.onclick = () => {
                        const checkboxSingle = multiple.querySelectorAll(
                            `${this.singleSelector}:not([no-check]):not([disabled])`
                        );
                        if (checkAll.checked) {
                            checkboxSingle.forEach((el) => (el.checked = true));
                            checkMultipleChild.forEach(
                                (el) => (el.checked = true)
                            );
                        } else {
                            checkboxSingle.forEach(
                                (el) => (el.checked = false)
                            );
                            checkMultipleChild.forEach(
                                (el) => (el.checked = false)
                            );
                        }
                        getData();
                        checkDisabled();
                    };
                }
            };

            var checkedSingle = () => {
                const checkboxSingle = multiple.querySelectorAll(
                    this.singleSelector
                );
                const checkAll = multiple.querySelector(this.allSelector);

                checkboxSingle.forEach((elm, indexEl) => {
                    let checkMultipleParent;
                    if (elm.closest(this.attributeForParentSelector)) {
                        checkMultipleParent = elm
                            .closest(this.attributeForParentSelector)
                            .querySelector(this.parentSelector);
                        if (
                            elm
                                .closest(this.attributeForParentSelector)
                                .querySelectorAll(this.singleSelector).length ==
                            0
                        ) {
                            checkMultipleParent.checked = false;
                        }
                    }

                    elm.onclick = () => {
                        const hasChecked = multiple.querySelectorAll(
                            `${this.singleSelector}:checked`
                        );
                        if (checkMultipleParent !== undefined) {
                            const childChecked = elm
                                .closest(this.attributeForParentSelector)
                                .querySelectorAll(
                                    `${this.singleSelector}:checked`
                                );
                            checkMultipleParent.checked =
                                childChecked.length > 0 ? true : false;
                        }
                        checkAll.checked =
                            hasChecked.length > 0 &&
                            hasChecked.length == checkboxSingle.length
                                ? true
                                : false;
                        getData();
                        checkDisabled();
                    };
                });
            };

            var checkedMultipleParentHasChild = () => {
                const checkboxMultipleChild = multiple.querySelectorAll(
                    this.parentSelector
                );
                checkboxMultipleChild.forEach((elm, indexEl) => {
                    elm.onclick = () => {
                        const checkboxSingle = elm
                            .closest(this.attributeForParentSelector)
                            .querySelectorAll(
                                `${this.singleSelector}:not([no-check]):not([disabled])`
                            );
                        if (elm.checked) {
                            checkboxSingle.forEach((el) => (el.checked = true));
                        } else {
                            checkboxSingle.forEach(
                                (el) => (el.checked = false)
                            );
                        }
                        getData();
                        checkDisabled();
                    };
                });
            };

            var getData = () => {
                const inputNotChecked = multiple.querySelectorAll(
                    `${this.singleSelector}:not(:checked)`
                );
                const inputHasChecked = multiple.querySelectorAll(
                    `${this.singleSelector}:checked`
                );
                const arrayData = [];
                const arrayDataNotChecked = [];
                Array.from(inputHasChecked).forEach((el) => {
                    const parentOfEl =
                        el.parentElement.parentElement.parentElement;
                    const list = parentOfEl.querySelectorAll(
                        `[${this.inputGetData}]:not([disabled])`
                    );
                    var dataValues = Array.from(list).reduce(
                        (values, input) => {
                            switch (input.type) {
                                default:
                                    if (input.name.indexOf("[]") > -1) {
                                        if (
                                            !Array.isArray(values[input.name])
                                        ) {
                                            values[
                                                input.getAttribute(
                                                    this.inputGetData
                                                )
                                            ] = [];
                                        }
                                        values[
                                            input.getAttribute(
                                                this.inputGetData
                                            )
                                        ].push(input.value);
                                    } else {
                                        values[
                                            input.getAttribute(
                                                this.inputGetData
                                            )
                                        ] = input.value;
                                    }
                                    break;
                            }
                            return values;
                        },
                        {}
                    );
                    arrayData.push(dataValues);
                }, []);

                Array.from(inputNotChecked).forEach((el) => {
                    const parentOfEl =
                        el.parentElement.parentElement.parentElement;
                    const list = parentOfEl.querySelectorAll(
                        `[${this.inputGetData}]:not([disabled])`
                    );
                    var dataValues = Array.from(list).reduce(
                        (values, input) => {
                            switch (input.type) {
                                default:
                                    if (input.name.indexOf("[]") > -1) {
                                        if (
                                            !Array.isArray(values[input.name])
                                        ) {
                                            values[
                                                input.getAttribute(
                                                    this.inputGetData
                                                )
                                            ] = [];
                                        }
                                        values[
                                            input.getAttribute(
                                                this.inputGetData
                                            )
                                        ].push(input.value);
                                    } else {
                                        values[
                                            input.getAttribute(
                                                this.inputGetData
                                            )
                                        ] = input.value;
                                    }
                                    break;
                            }
                            return values;
                        },
                        {}
                    );
                    arrayDataNotChecked.push(dataValues);
                }, []);
                let data = JSON.parse(
                    localStorage.getItem(
                        multiple.getAttribute(this.mainSelector).toUpperCase()
                    )
                );

                data = data == "" || data == null ? [] : data;
                data = [...data, ...arrayData];
                const getAttributeFilter = multiple.querySelector(
                    this.attributeMainCompare
                );
                if (!getAttributeFilter) return;
                data = removeDuplicateTwoArrayObject(
                    data,
                    arrayDataNotChecked,
                    getAttributeFilter.getAttribute(this.inputGetData)
                );
                localStorage.setItem(
                    multiple.getAttribute(this.mainSelector).toUpperCase(),
                    JSON.stringify(data.length > 0 ? data : "")
                );

                if (main !== null) {
                    main.innerHTML = JSON.stringify(
                        data.length > 0 ? data : ""
                    );
                }
                registerGetCount(data.length);
            };

            var removeDuplicateTwoArrayObject = (arrayMain, arraySub, attr) => {
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
                    (item, index) =>
                        !getAttributeMain.includes(item[attr], index + 1)
                );
                return newArray;
            };

            var changeData = () => {
                const inputData = multiple.querySelectorAll(
                    `[${this.inputGetData}]`
                );
                inputData.forEach((inputEl) => {
                    inputEl.onchange = getData;
                });
            };

            var checkDisabled = () => {
                const checkSingles = multiple.querySelectorAll(
                    `${this.singleSelector}:checked`
                );
                const buttonActions = multiple.querySelectorAll("[c-disabled]");
                buttonActions.forEach(
                    (button) =>
                        (button.disabled =
                            checkSingles.length > 0 ? false : true)
                );
            };

            var checkStart = () => {
                const checkSingles = multiple.querySelectorAll(
                    `${this.singleSelector}:checked`
                );
                const noCheckSingle = multiple.querySelectorAll(
                    this.singleSelector
                );
                let cMulti;
                if ((cMulti = multiple.querySelector(this.allSelector))) {
                    cMulti.checked =
                        noCheckSingle.length > 0 &&
                        checkSingles.length === noCheckSingle.length
                            ? true
                            : false;
                }
            };

            var registerGetCount = (count) => {
                multiple.querySelectorAll(this.getCount).forEach((selector) => {
                    selector.innerHTML = count;
                });
            };

            return {
                _: (() => {
                    clearStorage();
                    checkedSingle();
                    checkedMultipleParentHasChild();
                    checkedAll();
                    checkStart();
                    changeData();
                    getData();
                    // registerGetCount();
                })(),
            };
        });
    }
}

var M_CHECKBOX = new checkBoxTable();
