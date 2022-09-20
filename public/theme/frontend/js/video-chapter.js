const RATING_COURSE = (() => {
    return {
        _: () => {},
        ratingDone: (res, data, form) => {
            form.closest(".form-rating__teacher").innerHTML = res.html;
        },
        ratingTeacher: (res, data, form) => {
            form.closest(".form-rating__teacher").innerHTML = res.html;
        },
    };
})();
window.addEventListener("DOMContentLoaded", function () {
    RATING_COURSE._();
});
