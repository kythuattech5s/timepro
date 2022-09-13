var MODULE_QUESTION_EXAM = {
    getQuestionAnswerBox: function (dataExam, questionIdx) {
        return $("[question=" + questionIdx + "]").find(
            ".list-question-answer"
        );
    },
    getValue: function (dataExam, questionIdx) {
        var questionAnswerBox = MODULE_QUESTION_EXAM.getQuestionAnswerBox(
            dataExam,
            questionIdx
        );
        var fnc = "getValue" + dataExam[questionIdx].type;
        return MODULE_QUESTION.callInternalFunc(fnc, questionAnswerBox);
    },
    disableAnswerQuestion: function (dataExam, questionIdx) {
        var questionAnswerBox = MODULE_QUESTION_EXAM.getQuestionAnswerBox(
            dataExam,
            questionIdx
        );
        var fnc = "disableAnswerQuestion" + dataExam[questionIdx].type;
        return MODULE_QUESTION.callInternalFunc(fnc, questionAnswerBox);
    },
    getQuestionDoStatus: function (dataExam, questionIdx) {
        var questionAnswerBox = MODULE_QUESTION_EXAM.getQuestionAnswerBox(
            dataExam,
            questionIdx
        );
        var fnc = "getQuestionDoStatus" + dataExam[questionIdx].type;
        return MODULE_QUESTION.callInternalFunc(fnc, questionAnswerBox);
    },
};
var MODULE_EXAM = (function () {
    var countDown;
    var initAudio = function (argument) {
        $("#module-content__exam").ubaPlayer({
            audioButtonClass: "audio-question",
            codecs: [{ name: "MP3", codec: "audio/mpeg;" }],
        });
    };
    var initStartExam = function () {
        var currentDate = new Date();
        var startTime =
            currentDate.getFullYear() +
            "-" +
            ("0" + (currentDate.getMonth() + 1)).slice(-2) +
            "-" +
            ("0" + currentDate.getDate()).slice(-2) +
            " " +
            ("0" + currentDate.getHours()).slice(-2) +
            ":" +
            ("0" + currentDate.getMinutes()).slice(-2) +
            ":" +
            ("0" + currentDate.getSeconds()).slice(-2);
        dataExam.exam.start_time = startTime;
        $("#module-content__exam")
            .find(".module-content__exam")
            .removeClass("do-start");
        $("#module-content__exam")
            .find(".form-button__submit")
            .removeClass("d-none");
        if (dataExam.exam.has_time == 1) {
            setTimeout(function () {
                $("#count-down-exam").removeClass("d-none");
            }, 1000);
            countDown = new CountDown(
                $("#count-down-exam"),
                dataExam.exam.time
            );
            countDown.setCallback("MODULE_EXAM.countDownDone", [
                countDown.currentElment,
            ]);
            countDown.start();
        }
    };
    var submitExam = function (elm) {
        buildResultExam();
        if (dataExam.exam.status == 0) {
            $.confirm({
                closeIcon: true,
                columnClass:
                    "col-12 col-md-8 col-md-offset-4 col-xl-6 col-xl-offset-6",
                typeAnimated: true,
                title: `<p class="fz-24 f-bold text-center">Xác nhận nộp bài</p>`,
                content:
                    '<p class="fz-18 text-center">Bạn chưa hoàn thành hết câu hỏi. Bạn có muốn tiếp tục nộp bài.</p>',
                buttons: {
                    continue: {
                        text: '<i class="fa fa-play me-2" aria-hidden="true"></i> Nộp bài',
                        btnClass: "btn btn-yellow__all px-3 py-2 me-3",
                        action: function () {
                            MODULE_EXAM._submitExam(elm);
                        },
                    },
                    close: {
                        text: '<i class="fa fa-pencil-square-o me-2" aria-hidden="true"></i> Làm tiếp',
                        btnClass: "btn-green__all text-white px-3 py-2",
                        action: function () {},
                    },
                },
            });
            return;
        } else {
            $.confirm({
                closeIcon: true,
                columnClass:
                    "col-12 col-md-8 col-md-offset-4 col-xl-6 col-xl-offset-6",
                typeAnimated: true,
                title: `<p class="fz-24 f-bold text-center">Bạn có chăc chắn muốn nộp bài không?</p>`,
                content: " ",
                buttons: {
                    continue: {
                        text: '<i class="fa fa-play me-2" aria-hidden="true"></i> Nộp bài',
                        btnClass: "btn btn-yellow__all px-3 py-2 me-3",
                        action: function () {
                            MODULE_EXAM._submitExam(elm);
                        },
                    },
                    close: {
                        text: '<i class="fa fa-pencil-square-o me-2" aria-hidden="true"></i> Làm tiếp',
                        btnClass: "btn-green__all text-white px-3 py-2",
                        action: function () {},
                    },
                },
            });
            return;
        }
    };
    var _submitExam = function (elm) {
        $(elm).remove();
        if (typeof countDown != "undefined") {
            countDown.stop();
        }
        var url = "";
        if (dataExam.exam.type == "ability_exam") {
            url = "send-ability-exam-results";
        }
        if (dataExam.exam.type == "exam") {
            url = "send-exam-results";
        }
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: { data: dataExam },
        }).done(function (json) {
            $(".module-question-exam").each(function (index, el) {
                var questionIdx = parseInt($(this).attr("question"));
                MODULE_QUESTION_EXAM.disableAnswerQuestion(
                    dataExam,
                    questionIdx
                );
            });
            if (json.code == 200) {
                if (dataExam.exam.type == "exam") {
                    $.confirm({
                        closeIcon: true,
                        columnClass: "col-12 col-xl-8 col-xl-offset-4",
                        typeAnimated: true,
                        title: ` `,
                        content: json.html,
                        buttons: {
                            listExercise: {
                                text: '<i class="fa fa-list me-2" aria-hidden="true"></i> Danh sách bài kiểm tra',
                                btnClass:
                                    "btn-green__all text-white px-3 py-2 me-3",
                                action: function () {
                                    window.location.href = json.link_back;
                                },
                            },
                            redo: {
                                text: '<i class="fa fa-undo me-2" aria-hidden="true"></i> Làm lại',
                                btnClass: "btn btn-info text-white py-2",
                                action: function () {
                                    $.confirm({
                                        closeIcon: true,
                                        columnClass:
                                            "col-12 col-md-8 col-md-offset-4",
                                        typeAnimated: true,
                                        title: `<p class="f-bold fz-24 text-center">Xác nhận làm lại</p>`,
                                        content:
                                            '<div class="text-center fz-18">Làm lại sẽ không được tính số sao và điểm thành tích. Bạn có muốn xác nhận làm lại.</div>',
                                        buttons: {
                                            close: {
                                                text: '<i class="fa fa-window-close me-2" aria-hidden="true"></i> Đóng',
                                                btnClass:
                                                    "btn-gray__light px-3 py-2 me-3",
                                                action: function () {},
                                            },
                                            listExercise: {
                                                text: '<i class="fa fa-list me-2" aria-hidden="true"></i> Danh sách bài tập',
                                                btnClass:
                                                    "btn-green__all text-white px-3 py-2 me-3",
                                                action: function () {
                                                    window.location.href =
                                                        json.link_back;
                                                },
                                            },
                                            redo: {
                                                text: '<i class="fa fa-undo me-2" aria-hidden="true"></i> Làm lại',
                                                btnClass:
                                                    "btn btn-yellow__all py-2",
                                                action: function () {
                                                    window.location.reload();
                                                },
                                            },
                                        },
                                    });
                                },
                            },
                        },
                    });
                }
            } else {
                $.alert({
                    closeIcon: true,
                    type: "red",
                    columnClass:
                        "col-12 col-md-8 col-md-offset-4 col-lg-6 col-lg-offset-6",
                    typeAnimated: true,
                    title: json.message,
                    content: " ",
                    buttons: {
                        close: {
                            text: "Đóng",
                            btnClass: "btn btn-danger",
                            action: function () {
                                window.location.reload();
                            },
                        },
                    },
                });
            }
        });
    };
    var buildResultExam = function () {
        var statusExam = 1;
        $(".module-question-exam").each(function (index, el) {
            var questionIdx = parseInt($(this).attr("question"));
            dataExam[questionIdx].answer = MODULE_QUESTION_EXAM.getValue(
                dataExam,
                questionIdx
            );
            if (dataExam[questionIdx].answer == "") {
                statusExam = 0;
            }
        });
        dataExam.exam.status = statusExam;
    };
    var countDownDone = function (elm) {
        elm.html("Hết thời gian");
        buildResultExam();
        _submitExam($("#module-content__exam .form-button__submit button"));
    };
    return {
        _: function () {
            initStartExam();
            initAudio();
        },
        countDownDone(elm) {
            countDownDone(elm);
        },
        submitExam(elm) {
            submitExam(elm);
        },
        _submitExam(elm) {
            _submitExam(elm);
        },
    };
})();
$(document).ready(function () {
    MODULE_EXAM._();
});
