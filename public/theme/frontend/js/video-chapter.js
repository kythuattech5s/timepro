const RATING_COURSE = (() => {
    const commentNow = () => {};

    return {
        _: () => {},
        ratingDone: (res, data, form) => {
            form.closest(".form-rating__teacher").innerHTML = res.html;
        },
    };
})();
window.addEventListener("DOMContentLoaded", function () {
    RATING_COURSE._();
});
