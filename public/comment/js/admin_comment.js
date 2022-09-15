var COMMENT = (function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var openRepEvalue = function () {
        $(document).on("click", ".comment-item__rep", function () {
            if ($(this).parent().find(".form-comment__rep").length == 0) {
                $(this).parent()
                    .append(`<form class="form-comment__rep" action="cmrs/source/tra-loi-binh-luan" method="POST">
                <input type="hidden" name="parent" value="${$(this).attr(
                    "data-id"
                )}">
                <textarea placeholder="Hãy nhập bình luận của bạn..." name="content"></textarea>
                <button class="form-comment__rep-btn type="submit">Trả lời</button>
                </form>`);
            } else {
                $(this).parent().find(".form-comment__rep").slideToggle("slow");
            }
        });
    };

    var repComment = function () {
        $(document).on("submit", ".form-comment__rep", function (event) {
            var _this = $(this);
            let id = _this.find('input[name="parent"]').val();
            event.preventDefault();
            $.ajax({
                url: _this.attr("action"),
                type: "POST",
                data: _this.serialize(),
                beforeSend: function () {},
            }).done(function (json) {
                if (json.code == 200) {
                    $.simplyToast(json.message, "success");
                    fetchComment(id);
                } else {
                    $.simplyToast(json.message, "danger");
                }
            });
        });
    };

    var fetchComment = function ($id) {
        $.ajax({
            url: "cmrs/source/fetch-comment/" + $id,
            type: "GET",
            beforeSend: function () {},
        }).done(function (json) {
            $(".comment-detail").html(json.view);
        });
    };

    var switchAct = function () {
        $(document).on(
            "change",
            '.switch-item input[type="checkbox"]',
            function (event) {
                event.preventDefault();
                let url =
                    "cmrs/source/change-act/" +
                    $(this).parent().data("id");
                let checked = 1;
                if ($(this).prop("checked") == true) {
                    checked = 1;
                } else {
                    checked = 0;
                }
                $.ajax({
                    url: url,
                    data: {
                        act: checked,
                    },
                }).done(function (json) {
                    if (json.code == 200) {
                        $.simplyToast(json.message, "success");
                    } else {
                        $.simplyToast(json.message, "danger");
                    }
                });
            }
        );
    };

    return {
        _: (() => {
            document.addEventListener("DOMContentLoaded", function () {
                switchAct();
                repComment();
                openRepEvalue();
            });
        })(),
    };
})();