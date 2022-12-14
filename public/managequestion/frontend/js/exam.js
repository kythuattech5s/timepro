$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
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
    var initBaseContent = function () {
        $(".btn-start-exam").click(function () {
            $(this).remove();
            initStartExam();
        });
        if (dataExam.exam.type == "obligatory_exam") {
            initStartExam();
        }
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
        $("#module-content__exam").removeClass("hidden");
        if (dataExam.exam.has_time == 1) {
            $(".box-exam-time").removeClass("hidden");
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
                columnClass: "max-width-800",
                typeAnimated: true,
                title: `<p class="title font-bold text-[#252525] 2xl:text-[1.25rem] text-[1.15rem] text-center">X??c nh???n n???p b??i</p>`,
                content:
                    '<p class="2xl:text-[1.15rem] text-[1rem]">B???n ch??a ho??n th??nh h???t c??u h???i. B???n c?? mu???n ti???p t???c n???p b??i.</p>',
                buttons: {
                    continue: {
                        text: '<i class="fa fa-play me-2" aria-hidden="true"></i> N???p b??i',
                        btnClass: "btn-red px-3 py-2 me-3",
                        action: function () {
                            MODULE_EXAM._submitExam(elm);
                        },
                    },
                    close: {
                        text: '<i class="fa fa-pencil-square-o me-2" aria-hidden="true"></i> L??m ti???p',
                        btnClass: "btn-blue text-white px-3 py-2",
                        action: function () {},
                    },
                },
            });
            return;
        } else {
            $.confirm({
                closeIcon: true,
                columnClass: "max-width-800",
                typeAnimated: true,
                title: `<p class="title font-bold text-[#252525] 2xl:text-[1.25rem] text-[1.15rem] text-center">B???n c?? ch??c ch???n mu???n n???p b??i kh??ng?</p>`,
                content: " ",
                buttons: {
                    close: {
                        text: '<i class="fa fa-pencil-square-o me-2" aria-hidden="true"></i> L??m ti???p',
                        btnClass: "btn-blue text-white px-3 py-2",
                        action: function () {},
                    },
                    continue: {
                        text: '<i class="fa fa-play me-2" aria-hidden="true"></i> N???p b??i',
                        btnClass: "btn-green px-3 py-2 me-3",
                        action: function () {
                            MODULE_EXAM._submitExam(elm);
                        },
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
        url = "send-exam-results";
        if (dataExam.exam.type == "obligatory_exam") {
            url = "send-obligatory-exam-results";
        }
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: { data: dataExam },
        }).done(function (json) {
            $(".module-question-exam").each(function () {
                var questionIdx = parseInt($(this).attr("question"));
                MODULE_QUESTION_EXAM.disableAnswerQuestion(
                    dataExam,
                    questionIdx
                );
            });
            if (json.code == 200) {
                $.confirm({
                    closeIcon: true,
                    columnClass: "max-width-800",
                    typeAnimated: true,
                    title: json.message,
                    content: json.html,
                    buttons: {
                        listExercise: {
                            text: '<i class="fa fa-list me-2" aria-hidden="true"></i> Danh s??ch k??? thi',
                            btnClass: "btn-blue text-white px-3 py-2 me-3",
                            action: function () {
                                window.location.href = json.link_back;
                            },
                        },
                        viewResult: {
                            text: '<i class="fa fa-check-square-o me-2" aria-hidden="true"></i> Xem l???i gi???i',
                            btnClass: "btn btn-green text-white py-2",
                            action: function () {
                                window.location.href = json.link_result;
                            },
                        },
                    },
                });
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
                            text: "????ng",
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
        elm.html("H???t th???i gian");
        buildResultExam();
        _submitExam($("#module-content__exam .form-button__submit button"));
    };
    return {
        _: function () {
            initBaseContent();
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
