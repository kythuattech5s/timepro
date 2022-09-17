const RS = (() => {
    return {
        convertDate: function (str) {
            var date = new Date(str),
                mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                day = ("0" + date.getDate()).slice(-2);
            return [date.getFullYear(), mnth, day].join("-");
        },
        number_format:  (number, oneChar = ",", twoChar = ".") => {
            return Intl.NumberFormat()
                .format(number)
                .replaceAll(oneChar, twoChar);
        },
        inputNumber(input, min = 0, max = 100000000000) {
            const number = input.value || 0;
            const n = number.toString().replaceAll(/[^\d]/g, "");
            if (n >= min && n <= max) {
                input.value = input.value;
            } else {
                input.value = n.slice(0, -1);
            }
        },
        nonAccentVietnamese: (keyword) => {
            keyword = keyword.replace(
                /à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,
                "a"
            );
            keyword = keyword.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
            keyword = keyword.replace(/ì|í|ị|ỉ|ĩ/g, "i");
            keyword = keyword.replace(
                /ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,
                "o"
            );
            keyword = keyword.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
            keyword = keyword.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
            keyword = keyword.replace(/đ/g, "d");
            keyword = keyword.replace(
                /\u0300|\u0301|\u0303|\u0309|\u0323/g,
                ""
            ); // Huyền sắc hỏi ngã nặng
            keyword = keyword.replace(/\u02C6|\u0306|\u031B/g, ""); // Â, Ê, Ă, Ơ, Ư
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
            let newArray = arrayMain.filter(objectMain => {
                return !arraySub.some(objectSub => {
                    return objectMain[attr] == objectSub[attr];
                });
            });
            // Get Attribute Main RemoveAttributeSub
            const getAttributeMain = newArray.map(item => item[attr]);
            // Remove Duplicate
            newArray = newArray.filter((item, index) => !getAttributeMain.includes(item[attr], index + 1))
            return newArray;
        }
    };
})();
