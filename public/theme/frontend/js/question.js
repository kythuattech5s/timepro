var ASK_AND_ANSWER = (() => {
    return {
        init: (() => {})(),
        showNotify: (res) => {
            NOTIFICATION.showNotify(res.code, res.message);
        },
    };
})();
