$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
function fixTinymceFileManager(t, i, a, s) {
    e = tinymce.activeEditor;
    var r = $(window).innerWidth() - 30,
        g = $(window).innerHeight() - 60;
    if ((r > 1800 && (r = 1800), g > 1200 && (g = 1200), r > 600)) {
        var d = (r - 20) % 138;
        r = r - d + 10;
    }
    (urltype = 2), "image" == a && (urltype = 1), "media" == a && (urltype = 3);
    var o = "Tech5s FileManager";
    "undefined" != typeof e.settings.filemanager_title &&
        e.settings.filemanager_title &&
        (o = e.settings.filemanager_title);
    var l = "key";
    "undefined" != typeof e.settings.filemanager_sort_by &&
        e.settings.filemanager_sort_by &&
        (f = "&sort_by=" + e.settings.filemanager_sort_by);
    var m = "false";
    "undefined" != typeof e.settings.filemanager_descending &&
        e.settings.filemanager_descending &&
        (m = e.settings.filemanager_descending);
    var v = "";
    "undefined" != typeof e.settings.filemanager_crossdomain &&
        e.settings.filemanager_crossdomain &&
        ((v = "&crossdomain=1"),
        window.addEventListener
            ? window.addEventListener("message", n, !1)
            : window.attachEvent("onmessage", n)),
        tinymce.activeEditor.windowManager.open(
            {
                title: o,
                file: e.settings.external_filemanager_path + "?istiny=2",
                width: r,
                height: g,
                resizable: !0,
                maximizable: !0,
                inline: 1,
            },
            {
                setUrl: function (n) {
                    var i = s.document.getElementById(t);
                    if (
                        ((i.value = e.convertURL(n)), "createEvent" in document)
                    ) {
                        var a = document.createEvent("HTMLEvents");
                        a.initEvent("change", !1, !0), i.dispatchEvent(a);
                    } else i.fireEvent("onchange");
                    tinymce.activeEditor.windowManager.close();
                },
            }
        );
}
var QUESTION_MANAGE_GUI = {
    copyToClipboard: function (elem) {
        var targetId = "_hiddenCopyText_";
        var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
        var origSelectionStart, origSelectionEnd;
        if (isInput) {
            target = elem;
            origSelectionStart = elem.selectionStart;
            origSelectionEnd = elem.selectionEnd;
        } else {
            target = document.getElementById(targetId);
            if (!target) {
                var target = document.createElement("textarea");
                target.style.position = "fixed";
                target.style.left = "-9999px";
                target.style.top = "0";
                target.id = targetId;
                document.body.appendChild(target);
            }
            target.textContent = elem.textContent;
        }
        var currentFocus = document.activeElement;
        target.focus();
        target.setSelectionRange(0, target.value.length);
        var succeed;
        try {
            succeed = document.execCommand("copy");
        } catch (e) {
            succeed = false;
        }
        if (currentFocus && typeof currentFocus.focus === "function") {
            currentFocus.focus();
        }
        if (isInput) {
            elem.setSelectionRange(origSelectionStart, origSelectionEnd);
        } else {
            target.textContent = "";
        }
        return succeed;
    },
};
var QUESTION_MANAGE = {
    resultBox: $("#question_content_result"),
    questionType: $("select[name=question_type_id]"),
    init: function () {
        QUESTION_MANAGE.initQuestionView();
        QUESTION_MANAGE.initChangeTypeAction();
        QUESTION_MANAGE.initLoadListQuestion();
        QUESTION_MANAGE.initInputWidth();
    },
    initQuestionView: function () {
        if ($("#question_content_result").length == 0) return;
        if (typeof inEditQuestion != "undefined") {
            QUESTION_MANAGE.questionType.prop("disabled", "true");
            QUESTION_MANAGE.questionType.parent().css("background", "#eeeeee");
        }
        $.ajax({
            url: "manage-question/load-question-content-admin",
            type: "POST",
            dataType: "html",
            data: {
                nameField: $("#question_content_name").val(),
                value: $("#question_content_value").val(),
                type: QUESTION_MANAGE.questionType.val(),
            },
        }).done(function (data) {
            QUESTION_MANAGE.resultBox.html(data);
            QUESTION_MANAGE.reInitContentJs();
        });
    },
    editorBoxChangeCallBack: function () {
        QUESTION_MANAGE_FILL_ANSWER.buildData();
        QUESTION_MANAGE_DRAG_DROP.buildData();
    },
    initInputWidth: function () {
        $(document).on("input", ".input-auto-size", function (event) {
            $(this).attr("size", parseInt($(this).val().length) + 1);
        });
    },
    reInitContentJs: function () {
        QUESTION_MANAGE.resultBox.find(".editor_box").tinymce({
            height: 200,
            theme: "modern",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern tech5sfilemanager",
            ],
            toolbar1:
                "code preview |bold italic underline hr strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | removeformat subscript superscript",
            toolbar2:
                "styleselect formatselect fontselect fontsizeselect | link unlink table | forecolor backcolor | pastetext pagebreak | spellchecker | tech5sfilemanager | image media | mathSymbols",
            toolbar3: "",
            style_formats: [
                { title: "Bold text", inline: "b" },
                {
                    title: "Red text",
                    inline: "span",
                    styles: { color: "#ff0000" },
                },
                {
                    title: "Red header",
                    block: "h1",
                    styles: { color: "#ff0000" },
                },
                { title: "Example 1", inline: "span", classes: "example1" },
                { title: "Example 2", inline: "span", classes: "example2" },
                { title: "Table styles" },
                { title: "Table row 1", selector: "tr", classes: "tablerow1" },
            ],
            rel_list: [
                { title: "Nofollow", value: " nofollow" },
                { title: "Dofollow", value: "dofollow" },
            ],
            fontsize_formats:
                "10px 11px 12px 13px 14px 16px 18px 20px 22px 24px 30px 36px",
            lineheight_formats:
                "10px 11px 12px 13px 14px 16px 18px 20px 22px 24px 26px 28px 30px 32px 34px 36px 38px 40px 42px 46px 50px",
            inline_styles: true,
            entity_encoding: "raw",
            document_base_url: baseurl,
            image_advtab: true,
            external_filemanager_path: baseurl + admincp + "/media/view",
            filemanager_title: "Tech5s File Manager",
            external_plugins: {
                filemanager: baseurl + "admin/plug/tinymce/plugin.min.js",
                mathSymbols:
                    baseurl +
                    "admin/plug/tinymce/plugins/mathsymbols-tinymce-plugin/plugin.js",
            },
            file_browser_callback: function (field_name, url, type, win) {
                func_value = win.document.getElementById(field_name).value;
                fixTinymceFileManager(field_name, func_value, type, win);
            },
            setup: function (editor) {
                editor.on("change", function () {
                    editor.save();
                    QUESTION_MANAGE.editorBoxChangeCallBack();
                });
            },
        });
    },
    initChangeTypeAction: function () {
        $(document).on(
            "change",
            "select[name=question_type_id]",
            function (event) {
                event.preventDefault();
                QUESTION_MANAGE.clearDataContentQuestion();
                QUESTION_MANAGE.initQuestionView();
            }
        );
    },
    clearDataContentQuestion: function () {
        QUESTION_MANAGE.resultBox.html("");
    },
    initLoadListQuestion: function () {
        if ($("#list-question-result").length == 0) return;
        $(document).on("click", ".btn-fill-list-question", function (event) {
            event.preventDefault();
            var formLoadListQuestion = $(".form-load-list-question");
            $.ajax({
                url: formLoadListQuestion.data("action"),
                type: "POST",
                dataType: "html",
                data: {
                    currentItem: $(".current-item").val(),
                    defaultData: $(".default-data").val(),
                    q: formLoadListQuestion.find(".name-search").val(),
                    type: formLoadListQuestion.find("select").val(),
                },
            }).done(function (data) {
                $("#list-question-result").html(data);
            });
        });
        $(document).on("click", ".btn-accept-list-question", function (event) {
            event.preventDefault();
            var _this = $(this);
            var listValue = "";
            $(".list-question-item input:checked").each(function (index, el) {
                listValue = listValue + "," + $(this).val();
            });
            if (listValue == "") {
                alert("Vui lòng chọn ít nhất một câu hỏi");
                return;
            }
            $.ajax({
                url: _this.data("action"),
                type: "POST",
                dataType: "json",
                data: {
                    currentItem: $(".current-item").val(),
                    defaultData: $(".default-data").val(),
                    listValue: listValue,
                },
            }).done(function (json) {
                if (json.code == 200) {
                    window.location.reload();
                }
            });
        });
        $(document).on(
            "click",
            ".list-item-question-default .clear-item",
            function (event) {
                event.preventDefault();
                var _this = $(this);
                var accept = confirm(
                    "Bạn có chắc muốn xóa câu hỏi này khỏi bài tập"
                );
                if (!accept) {
                    return;
                }
                $.ajax({
                    url: _this.data("action"),
                    type: "POST",
                    dataType: "json",
                    data: {
                        currentItem: $(".current-item").val(),
                        defaultData: $(".default-data").val(),
                        target: _this.data("target"),
                    },
                }).done(function (json) {
                    if (json.code == 200) {
                        _this
                            .closest($(".list-item-question-default"))
                            .remove();
                    }
                });
            }
        );
        $(document).on(
            "click",
            ".btn-save-default-question-info",
            function (event) {
                event.preventDefault();
                var _this = $(this);
                var items = $(".list-item-question-default");
                var objs = [];
                for (var i = 0; i < items.length; i++) {
                    var item = $(items[i]);
                    var tmp = {};
                    tmp.point = item.find("input.point").val();
                    tmp.ord = item.find("input.ord").val();
                    tmp.id_target = item.data("id");
                    objs.push(tmp);
                }
                $.ajax({
                    url: _this.data("action"),
                    type: "POST",
                    dataType: "json",
                    data: {
                        currentItem: $(".current-item").val(),
                        defaultData: $(".default-data").val(),
                        infoQuestion: JSON.stringify({ ...objs }),
                    },
                }).done(function (json) {
                    if (json.code == 200) {
                        window.location.reload();
                    }
                });
            }
        );
        $(document).on(
            "click",
            ".btn-save-match-question-info",
            function (event) {
                event.preventDefault();
                var _this = $(this);
                var items = $(".list-item-question-default");
                var objs = [];
                for (var i = 0; i < items.length; i++) {
                    var item = $(items[i]);
                    var tmp = {};
                    tmp.is_multiply_point = item
                        .find("input.is_multiply_point")
                        .is(":checked")
                        ? 1
                        : 0;
                    tmp.ord = item.find("input.ord").val();
                    tmp.multiply_point = item
                        .find("input.multiply_point")
                        .val();
                    tmp.id_target = item.data("id");
                    objs.push(tmp);
                }
                $.ajax({
                    url: _this.data("action"),
                    type: "POST",
                    dataType: "json",
                    data: {
                        currentItem: $(".current-item").val(),
                        defaultData: $(".default-data").val(),
                        infoQuestion: JSON.stringify({ ...objs }),
                    },
                }).done(function (json) {
                    if (json.code == 200) {
                        window.location.reload();
                    }
                });
            }
        );
    },
};
var QUESTION_MANAGE_FILL_ANSWER = {
    init: function () {
        QUESTION_MANAGE_FILL_ANSWER.initCrateData();
        QUESTION_MANAGE_FILL_ANSWER.initBuildMathAdditionSubtractionMultiplication();
        QUESTION_MANAGE_FILL_ANSWER.initBuildMathNumberConcatenation();
    },
    initCrateData: function () {
        $(document).on(
            "click",
            ".button-add-input-fill-question",
            function (event) {
                event.preventDefault();
                var timeStampInMs =
                    window.performance &&
                    window.performance.now &&
                    window.performance.timing &&
                    window.performance.timing.navigationStart
                        ? window.performance.now() +
                          window.performance.timing.navigationStart
                        : Date.now();
                timeStampInMs = parseInt(timeStampInMs);
                var item =
                    `<div class="item-fill-answer d-flex mb-3">
				<div class="w-50 pr-2">
					<p class="form-title">Nội dung</p>
					<input type="text" class="w-100 form-control content-input" placeholder="Nội dung">
				</div>
				<div class="w-50 pl-2">
					<p class="form-title">Id Input</p>
					<div class="d-flex justify-content-between">
						<input type="text" class="form-control id-input" disabled readonly value="input_fill_answer_` +
                    timeStampInMs +
                    `">
						<div class="id-input-value-copy d-none">[input_fill_answer_` +
                    timeStampInMs +
                    `] </div>
						<div class="copy-input-fill-answer d-flex justify-content-center align-items-center">
							Copy kèm dấu []
						</div>
					</div>
				</div>
				<div class="clear-item-input">
					<i class="fa fa-times" aria-hidden="true"></i>
				</div>
			</div>`;
                $(".box-fill-answer .list-input").append(item);
                QUESTION_MANAGE_FILL_ANSWER.buildData();
            }
        );
        $(document).on(
            "click",
            ".box-fill-answer .clear-item-input",
            function (event) {
                event.preventDefault();
                $(this).closest(".item-fill-answer").remove();
                QUESTION_MANAGE_FILL_ANSWER.buildData();
            }
        );
        $(document).on(
            "input",
            ".box-fill-answer .content-input",
            function (event) {
                QUESTION_MANAGE_FILL_ANSWER.buildData();
            }
        );
        $(document).on(
            "click",
            ".box-fill-answer .copy-input-fill-answer",
            function (event) {
                event.preventDefault();
                var elem = $(this)
                    .closest(".item-fill-answer")
                    .find(".id-input-value-copy")[0];
                var statusCopy = QUESTION_MANAGE_GUI.copyToClipboard(elem);
                if (statusCopy) {
                    $.simplyToast("Đã copy thành công.", "success");
                } else {
                    $.simplyToast("Không thể copy tự động.", "warning");
                }
            }
        );
    },
    buildData: function () {
        if ($(".box-fill-answer").length == 0) return;
        var contentArea = $(".box-fill-answer .fill_answer_content").val();
        var contentTrueAnswer = $(
            ".box-fill-answer .fill_answer_true_content"
        ).val();
        var itemInputs = $(".list-input .item-fill-answer");
        var objs = {};
        objs.contentArea = contentArea;
        objs.contentTrueAnswer = contentTrueAnswer;
        objs.listInput = {};
        for (var i = 0; i < itemInputs.length; i++) {
            var item = $(itemInputs[i]);
            var id = item.find(".id-input").val();
            objs.listInput[id] = item.find(".content-input").val();
        }
        $("#content-fill-answer-question-info").text(
            JSON.stringify({ ...objs })
        );
    },
    initBuildMathAdditionSubtractionMultiplication: function () {
        $(document).on(
            "click",
            ".build-math-addition-subtraction-multiplication .btn-show-module-build",
            function (event) {
                $(this).parent().find(".content-build").slideDown(300);
            }
        );
        $(document).on(
            "click",
            ".build-math-addition-subtraction-multiplication .btn-rendder",
            function (event) {
                event.preventDefault();
                var mainBuild = $(this).closest(".main-build");
                $.ajax({
                    url: "manage-question/build-math-addition-subtraction-multiplication",
                    type: "POST",
                    dataType: "json",
                    data: {
                        line1: mainBuild.find(".line-part-1").val(),
                        line2: mainBuild.find(".line-part-2").val(),
                        line3: mainBuild.find(".line-part-3").val(),
                        operator: mainBuild.find(".item-operator").val(),
                    },
                }).done(function (json) {
                    $(
                        ".build-math-addition-subtraction-multiplication .preview .html-preview"
                    ).html(json.html);
                    $(
                        ".build-math-addition-subtraction-multiplication .preview #html-copy-addition-subtraction-multiplication"
                    ).html(json.html_copy);
                    $(
                        ".build-math-addition-subtraction-multiplication .btn-copy-html"
                    ).removeClass("d-none");
                });
            }
        );
        $(document).on(
            "click",
            ".build-math-addition-subtraction-multiplication .btn-copy-html",
            function (event) {
                event.preventDefault();
                elem = document.getElementById(
                    "html-copy-addition-subtraction-multiplication"
                );
                var statusCopy = QUESTION_MANAGE_GUI.copyToClipboard(elem);
                if (statusCopy) {
                    $.simplyToast("Đã copy thành công.", "success");
                } else {
                    $.simplyToast(
                        "Không thể copy tự động. Vui lòng copy mã sau đây",
                        "danger"
                    );
                    $(
                        "#html-copy-addition-subtraction-multiplication"
                    ).removeClass("d-none");
                }
            }
        );
    },
    initBuildMathNumberConcatenation: function () {
        $(document).on(
            "click",
            ".build-math-number-concatenation .btn-show-module-build",
            function (event) {
                $(this).parent().find(".content-build").slideDown(300);
            }
        );
        $(document).on(
            "click",
            ".build-math-number-concatenation .button-add-item",
            function (event) {
                var html = `<div class="item-number-concatenation">
							<input type="text" placeholder="Nhập nội dung">
							<div class="clear-item-input">
								<i class="fa fa-times" aria-hidden="true"></i>
							</div>
						</div>`;
                $(
                    ".build-math-number-concatenation .list-item-number-concatenation"
                ).append(html);
            }
        );
        $(document).on(
            "click",
            ".build-math-number-concatenation .clear-item-input",
            function (event) {
                $(this).closest(".item-number-concatenation").remove();
            }
        );
        $(document).on(
            "click",
            ".build-math-number-concatenation .btn-rendder",
            function (event) {
                event.preventDefault();
                var listItem = $(
                    ".build-math-number-concatenation .list-item-number-concatenation input"
                );
                var strVal = "";
                listItem.each(function (index, el) {
                    strVal = strVal + "|" + $(el).val();
                });
                $.ajax({
                    url: "manage-question/build-math-number-concatenation",
                    type: "POST",
                    dataType: "json",
                    data: {
                        strVal: strVal,
                    },
                }).done(function (json) {
                    $(
                        ".build-math-number-concatenation .preview .html-preview"
                    ).html(json.html);
                    $(
                        ".build-math-number-concatenation .preview #html-copy-number-concatenation"
                    ).html(json.html_copy);
                    $(
                        ".build-math-number-concatenation .btn-copy-html"
                    ).removeClass("d-none");
                });
            }
        );
        $(document).on(
            "click",
            ".build-math-number-concatenation .btn-copy-html",
            function (event) {
                event.preventDefault();
                elem = document.getElementById(
                    "html-copy-number-concatenation"
                );
                var statusCopy = QUESTION_MANAGE_GUI.copyToClipboard(elem);
                if (statusCopy) {
                    $.simplyToast("Đã copy thành công.", "success");
                } else {
                    $.simplyToast(
                        "Không thể copy tự động. Vui lòng copy mã sau đây",
                        "danger"
                    );
                    $(
                        "#html-copy-addition-subtraction-multiplication"
                    ).removeClass("d-none");
                }
            }
        );
    },
};
var QUESTION_MANAGE_DRAG_DROP = {
    init: function () {
        QUESTION_MANAGE_DRAG_DROP.initCrateData();
    },
    initCrateData: function () {
        $(document).on(
            "click",
            ".button-add-input-drag-drop-question",
            function (event) {
                event.preventDefault();
                var timeStampInMs =
                    window.performance &&
                    window.performance.now &&
                    window.performance.timing &&
                    window.performance.timing.navigationStart
                        ? window.performance.now() +
                          window.performance.timing.navigationStart
                        : Date.now();
                timeStampInMs = parseInt(timeStampInMs);
                var item =
                    `<div class="item-drag-drop d-flex mb-3">
				<div class="w-50 pr-2">
					<p class="form-title">Nội dung</p>
					<input type="text" class="w-100 form-control content-input" placeholder="Nội dung">
				</div>
				<div class="w-50 pl-2">
					<p class="form-title">Id Input</p>
					<div class="d-flex justify-content-between">
						<input type="text" class="form-control id-input" disabled readonly value="input_fill_answer_` +
                    timeStampInMs +
                    `">
						<div class="id-input-value-copy d-none">[input_fill_answer_` +
                    timeStampInMs +
                    `] </div>
						<div class="copy-input-drag-drop d-flex justify-content-center align-items-center">
							Copy kèm dấu []
						</div>
					</div>
				</div>
				<div class="clear-item-input">
					<i class="fa fa-times" aria-hidden="true"></i>
				</div>
			</div>`;
                $(".box-drag-drop .list-input").append(item);
                QUESTION_MANAGE_DRAG_DROP.buildData();
            }
        );
        $(document).on(
            "click",
            ".box-drag-drop .clear-item-input",
            function (event) {
                event.preventDefault();
                $(this).closest(".item-drag-drop").remove();
                QUESTION_MANAGE_DRAG_DROP.buildData();
            }
        );
        $(document).on(
            "input",
            ".box-drag-drop .content-input",
            function (event) {
                QUESTION_MANAGE_DRAG_DROP.buildData();
            }
        );
        $(document).on(
            "click",
            ".box-drag-drop .copy-input-drag-drop",
            function (event) {
                event.preventDefault();
                var elem = $(this)
                    .closest(".item-drag-drop")
                    .find(".id-input-value-copy")[0];
                var statusCopy = QUESTION_MANAGE_GUI.copyToClipboard(elem);
                if (statusCopy) {
                    $.simplyToast("Đã copy thành công.", "success");
                } else {
                    $.simplyToast("Không thể copy tự động.", "warning");
                }
            }
        );
    },
    buildData: function () {
        if ($(".box-drag-drop").length == 0) return;
        var contentArea = $(".box-drag-drop .drag_drop_content").val();
        var contentTrueAnswer = $(
            ".box-drag-drop .drag_drop_true_content"
        ).val();
        var itemInputs = $(".list-input .item-drag-drop");
        var objs = {};
        objs.contentArea = contentArea;
        objs.contentTrueAnswer = contentTrueAnswer;
        objs.listInput = {};
        for (var i = 0; i < itemInputs.length; i++) {
            var item = $(itemInputs[i]);
            var id = item.find(".id-input").val();
            objs.listInput[id] = item.find(".content-input").val();
        }
        $("#content-drag-drop-question-info").text(JSON.stringify({ ...objs }));
    },
};
var QUESTION_MANAGE_MATCHING = {
    init: function () {
        QUESTION_MANAGE_MATCHING.initCrateData();
    },
    initCrateData: function () {
        function randomInteger(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
        $(document).on(
            "click",
            ".button-add-input-matching-question",
            function (event) {
                event.preventDefault();
                var timeStampInMs =
                    window.performance &&
                    window.performance.now &&
                    window.performance.timing &&
                    window.performance.timing.navigationStart
                        ? window.performance.now() +
                          window.performance.timing.navigationStart
                        : Date.now();
                timeStampInMs = parseInt(timeStampInMs);
                var item =
                    `<div class="item-matching d-flex mb-3">
						<div class="w-50 pr-2">
							<p class="form-title">Nội dung trái</p>
							<input type="text" value="" class="w-100 form-control content-input content-input-left" placeholder="Nội dung trái">
						</div>
						<input type="hidden" class="hidden-id-item-left" value="matchingl_` +
                    timeStampInMs +
                    randomInteger(1000, 9999) +
                    `">
						<div class="w-50 pl-2">
							<p class="form-title">Nội dung phải</p>
							<input type="text" value="" class="w-100 form-control content-input content-input-right" placeholder="Nội dung trái">
						</div>
						<input type="hidden" class="hidden-id-item-right" value="matchingr_` +
                    timeStampInMs +
                    randomInteger(1000, 9999) +
                    `">
						<div class="clear-item-input">
							<i class="fa fa-times" aria-hidden="true"></i>
						</div>
					</div>`;
                $(".box-matching .list-input").append(item);
                QUESTION_MANAGE_MATCHING.buildData();
            }
        );
        $(document).on(
            "click",
            ".box-matching .clear-item-input",
            function (event) {
                event.preventDefault();
                $(this).closest(".item-matching").remove();
                QUESTION_MANAGE_MATCHING.buildData();
            }
        );
        $(document).on(
            "input",
            ".box-matching .content-input",
            function (event) {
                QUESTION_MANAGE_MATCHING.buildData();
            }
        );
        $(document).on(
            "click",
            ".box-matching .copy-input-matching",
            function (event) {
                event.preventDefault();
                var elem = $(this)
                    .closest(".item-matching")
                    .find(".id-input-value-copy")[0];
                var statusCopy = QUESTION_MANAGE_GUI.copyToClipboard(elem);
                if (statusCopy) {
                    $.simplyToast("Đã copy thành công.", "success");
                } else {
                    $.simplyToast("Không thể copy tự động.", "warning");
                }
            }
        );
    },
    buildData: function () {
        if ($(".box-matching").length == 0) return;
        var itemInputs = $(".list-input .item-matching");
        var objs = {};
        objs.listInput = [];
        for (var i = 0; i < itemInputs.length; i++) {
            var item = $(itemInputs[i]);
            var idItem = item.find(".hidden-id-item").val();
            objs.listInput[i] = {};
            objs.listInput[i].left = {};
            objs.listInput[i].left.id = item.find(".hidden-id-item-left").val();
            objs.listInput[i].left.value = item
                .find(".content-input-left")
                .val();

            objs.listInput[i].right = {};
            objs.listInput[i].right.id = item
                .find(".hidden-id-item-right")
                .val();
            objs.listInput[i].right.value = item
                .find(".content-input-right")
                .val();
        }
        $("#content-matching-question-info").text(JSON.stringify({ ...objs }));
    },
};
var QUESTION_CLICK_WORD = {
    init: function () {
        QUESTION_CLICK_WORD.initCrateData();
    },
    initCrateData: function () {
        $(document).on("click", ".btn-add-item-click-word", function (event) {
            event.preventDefault();
            var timeStampInMs =
                window.performance &&
                window.performance.now &&
                window.performance.timing &&
                window.performance.timing.navigationStart
                    ? window.performance.now() +
                      window.performance.timing.navigationStart
                    : Date.now();
            timeStampInMs = parseInt(timeStampInMs);
            var item = `<div class="item-click-word mb-3 position-relative">
				<input type="hidden" class="item-word-id" value="itclw_id_${timeStampInMs}">
  				<div class="list-item-word d-flex flex-wrap justify-content-center">
  					
  				</div>
  				<div class="action-word d-flex justify-content-between">
  					<select class="text-align-mode">
  						<option value="1" selected>Căn trái</option>
  						<option value="2">Căn giữa</option>
  						<option value="3">Căn phải</option>
  					</select>
  					<div>
  						<button type="button" class="btn-add-word">Thêm từ có thể click</button>
  						<button type="button" class="btn-add-word-noclick-able">Thêm từ không thể click</button>
  						<button type="button" class="btn-down-line-word">Xuống dòng</button>
  					</div>
  				</div>
	  			<div class="clear-item-click-word cspoint">
	  				<i class="fa fa-times" aria-hidden="true"></i>
	  			</div>
	  		</div>`;
            $(".list-item-click-word").append(item);
            QUESTION_CLICK_WORD.buildData();
        });
        $(document).on(
            "click",
            ".list-item-click-word .clear-item-click-word",
            function (event) {
                event.preventDefault();
                $(this).closest(".item-click-word").remove();
                QUESTION_CLICK_WORD.buildData();
            }
        );
        $(document).on(
            "click",
            ".item-click-word .btn-add-word",
            function (event) {
                event.preventDefault();
                var timeStampInMs =
                    window.performance &&
                    window.performance.now &&
                    window.performance.timing &&
                    window.performance.timing.navigationStart
                        ? window.performance.now() +
                          window.performance.timing.navigationStart
                        : Date.now();
                timeStampInMs = parseInt(timeStampInMs);
                var item = `<div class="item-word d-flex align-items-center position-relative" type="clickable">
					<input type="text" class="item-word-value input-auto-size" size="2">
					<label class="module-checkbox mx-1">
						<input type="checkbox" class="item-word-check">
						<span class="checkmark"></span>
					</label>
					<input type="hidden" class="item-word-id" value="itwclw_id_${timeStampInMs}">
					<div class="clear-item-word cspoint">
						<i class="fa fa-times" aria-hidden="true"></i>
					</div>
				</div>`;
                $(this)
                    .closest(".item-click-word")
                    .find(".list-item-word")
                    .append(item);
                QUESTION_CLICK_WORD.buildData();
            }
        );
        $(document).on(
            "click",
            ".item-click-word .btn-add-word-noclick-able",
            function (event) {
                event.preventDefault();
                var item = `<div class="item-word d-flex align-items-center position-relative" type="unclickable">
					<input type="text" class="item-word-value input-auto-size mr-1" size="2">
					<div class="clear-item-word cspoint">
						<i class="fa fa-times" aria-hidden="true"></i>
					</div>
				</div>`;
                $(this)
                    .closest(".item-click-word")
                    .find(".list-item-word")
                    .append(item);
                QUESTION_CLICK_WORD.buildData();
            }
        );
        $(document).on(
            "click",
            ".item-click-word .btn-down-line-word",
            function (event) {
                event.preventDefault();
                var item = `<div class="item-word d-flex justify-content-end" type="downline">
					<div class="clear-item-word cspoint">
						<i class="fa fa-times" aria-hidden="true"></i>
					</div>
				</div>`;
                $(this)
                    .closest(".item-click-word")
                    .find(".list-item-word")
                    .append(item);
                QUESTION_CLICK_WORD.buildData();
            }
        );
        $(document).on(
            "click",
            ".list-item-click-word .clear-item-word",
            function (event) {
                event.preventDefault();
                $(this).closest(".item-word").remove();
                QUESTION_CLICK_WORD.buildData();
            }
        );
        $(document).on(
            "input",
            ".box-click-word .item-word-value",
            function (event) {
                QUESTION_CLICK_WORD.buildData();
            }
        );
        $(document).on(
            "change",
            ".box-click-word .item-word-check",
            function (event) {
                QUESTION_CLICK_WORD.buildData();
            }
        );
        $(document).on(
            "change",
            ".box-click-word .text-align-mode",
            function (event) {
                QUESTION_CLICK_WORD.buildData();
            }
        );
    },
    buildData: function () {
        if ($(".box-click-word").length == 0) return;
        var itemInputs = $(".item-click-word");
        var objs = {};
        for (var i = 0; i < itemInputs.length; i++) {
            var item = $(itemInputs[i]);
            var idItem = item.find(".item-word-id").val();
            objs[idItem] = {};
            objs[idItem].listWords = {};
            objs[idItem].textAlign = item.find(".text-align-mode").val();
            var listWords = item.find(".item-word");
            for (var j = 0; j < listWords.length; j++) {
                var itemWord = $(listWords[j]);
                var tmp = {};
                tmp.type = itemWord.attr("type");
                tmp.value = itemWord.find(".item-word-value").val();
                tmp.id = itemWord.find(".item-word-id").val();
                var valueIsTrue = 0;
                var checkBox = itemWord.find(".item-word-check");
                if (typeof checkBox != "undefined") {
                    valueIsTrue = checkBox.is(":checked") ? 1 : 0;
                }
                tmp.isTrue = valueIsTrue;
                objs[idItem].listWords[j] = tmp;
            }
        }
        $("#content-click-word-question-info").text(
            JSON.stringify({ ...objs })
        );
    },
};
$(document).ready(function () {
    QUESTION_MANAGE.init();
    QUESTION_MANAGE_FILL_ANSWER.init();
    QUESTION_MANAGE_DRAG_DROP.init();
    QUESTION_MANAGE_MATCHING.init();
    QUESTION_CLICK_WORD.init();
});
