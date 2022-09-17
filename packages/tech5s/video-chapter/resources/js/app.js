(() => {
    load = () => {
        const video = document.querySelector("video");
    };

    return {
        init: (() => {
            load();
        })(),
    };
})();
