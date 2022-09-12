var turnAudiorightWrongNotice;
var slideExam;
var MODULE_QUESTION_EXERCISE = {
    getQuestionAnswerBox: function (dataExercises, questionIdx) {
        return $("[question=" + questionIdx + "]").find(
            ".list-question-answer"
        );
    },
    getValue: function (dataExercises, questionIdx) {
        var questionAnswerBox = MODULE_QUESTION_EXERCISE.getQuestionAnswerBox(
            dataExercises,
            questionIdx
        );
        var fnc = "getValue" + dataExercises[questionIdx].type;
        return MODULE_QUESTION.callInternalFunc(fnc, questionAnswerBox);
    },
    getQuestionDoStatus: function (dataExercises, questionIdx) {
        var questionAnswerBox = MODULE_QUESTION_EXERCISE.getQuestionAnswerBox(
            dataExercises,
            questionIdx
        );
        var fnc = "getQuestionDoStatus" + dataExercises[questionIdx].type;
        return MODULE_QUESTION.callInternalFunc(fnc, questionAnswerBox);
    },
    disableAnswerQuestion: function (dataExercises, questionIdx) {
        var questionAnswerBox = MODULE_QUESTION_EXERCISE.getQuestionAnswerBox(
            dataExercises,
            questionIdx
        );
        var fnc = "disableAnswerQuestion" + dataExercises[questionIdx].type;
        return MODULE_QUESTION.callInternalFunc(fnc, questionAnswerBox);
    },
    checkQuestionResult: function (dataExercises, questionIdx) {
        var questionAnswerBox = MODULE_QUESTION_EXERCISE.getQuestionAnswerBox(
            dataExercises,
            questionIdx
        );
        var answer = MODULE_QUESTION_EXERCISE.getValue(
            dataExercises,
            questionIdx
        );
        var correct = dataExercises[questionIdx].correct;
        var fnc = "checkCompareAnswer" + dataExercises[questionIdx].type;
        return MODULE_QUESTION.callInternalFunc(fnc, answer, correct);
    },
};
var MODULE_EXERCISE = (function () {
    var audio_clickbtn = document.getElementById("audio_clickbtn");
    var audio_correct = document.getElementById("audio_correct");
    var audio_incorrect = document.getElementById("audio_incorrect");
    var audio_skipques = document.getElementById("audio_skipques");
    var audio_point_finish = document.getElementById("audio_point_finish");
    var pointBox = $(".total-point-box");
    var countDown;
    var initSlideExam = function () {
        if (typeof Tech.$(".slide-question-exam") === "undefined") return;
        slideExam = new Swiper(".slide-question-exam", {
            slidesPerView: 1,
            disableOnInteraction: true,
            speed: 0,
            autoHeight: false,
            spaceBetween: 20,
            allowTouchMove: false,
        });
    };
    var initClickKeyboard = function () {
        $(".content-exam").each(function (index, el) {
            var listInput = $(el).find("input[type=text]");
            if (listInput.length > 0) {
                $(listInput[0]).addClass("on-focus-input");
            }
        });
        $(document).on(
            "click",
            ".content-exam input[type=text]",
            function (event) {
                $(this)
                    .closest(".content-exam")
                    .find("input[type=text]")
                    .removeClass("on-focus-input");
                $(this).addClass("on-focus-input");
            }
        );
        $(document).on("click", ".box_keyboard ._k_hidden", function (event) {
            event.preventDefault();
            $(this).closest(".box_keyboard").slideUp(300);
        });
        $(document).on("click", ".box_keyboard ._keypad", function (event) {
            var inputFocused = $(this)
                .closest(".content-exam ")
                .find("input.on-focus-input")
                .not(":disabled");
            if (inputFocused.length > 0) {
                var val = inputFocused.val();
                if ($(this).hasClass("del")) {
                    inputFocused
                        .val(
                            val.length > 0
                                ? val.substring(0, val.length - 1)
                                : val
                        )
                        .trigger("input");
                } else {
                    inputFocused.val(val + $(this).text()).trigger("input");
                }
            }
        });
    };
    var initCountDownTime = function () {
        if (dataExercises.exercises.has_time == 1) {
            setTimeout(function () {
                $("#count-down-exercise").removeClass("d-none");
            }, 1000);
            countDown = new CountDown(
                $("#count-down-exercise"),
                dataExercises.exercises.time
            );
            countDown.setCallback("MODULE_EXERCISE.countDownDone", [
                countDown.currentElment,
            ]);
            countDown.start();
        }
    };
    var countDownDone = function (elm) {
        elm.html("Hết thời gian");
        $("[question]").each(function (index, el) {
            var questionIdx = parseInt($(this).attr("question"));
            if (dataExercises[questionIdx].status == 0) {
                finishQuestion($(el), dataExercises, questionIdx);
            }
        });
    };
    var randomInteger = function (min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    };
    var initPopupQuestionResultPosition = function () {
        $(".false-popup").css(
            "margin-top",
            "-" + $(".false-popup").innerHeight() / 2 + "px"
        );
        $(".skip-popup").css(
            "margin-top",
            "-" + $(".skip-popup").innerHeight() / 2 + "px"
        );
        $(".success-popup").css(
            "margin-top",
            "-" + $(".success-popup").innerHeight() / 2 + "px"
        );

        $(".false-popup").css(
            "margin-left",
            "-" + $(".false-popup").innerWidth() / 2 + "px"
        );
        $(".skip-popup").css(
            "margin-left",
            "-" + $(".skip-popup").innerWidth() / 2 + "px"
        );
        $(".success-popup").css(
            "margin-left",
            "-" + $(".success-popup").innerWidth() / 2 + "px"
        );
        $(".content-item-popup").addClass("d-none");
    };
    var playClickAudio = function () {
        audio_clickbtn.play();
    };
    var playCorrectAudio = function () {
        if (turnAudiorightWrongNotice) {
            audio_correct.play();
        }
    };
    var playSkipques = function () {
        if (turnAudiorightWrongNotice) {
            audio_skipques.play();
        }
    };
    var playIncorrectAudio = function () {
        if (turnAudiorightWrongNotice) {
            audio_incorrect.play();
        }
    };
    var playFinishAudio = function () {
        audio_point_finish.play();
    };
    var showFalsePopUp = function (argument) {
        var contentPopup = $(".false-popup").find(".content-item-popup");
        if (contentPopup.length == 0) return;
        var numberRand = randomInteger(0, contentPopup.length - 1);
        $(contentPopup[numberRand]).removeClass("d-none");
        $(".false-popup").css("display", "block");
        setTimeout(function () {
            $(".false-popup").css("display", "none");
            $(contentPopup[numberRand]).addClass("d-none");
        }, 1500);
    };
    var showSkipPopUp = function (argument) {
        var contentPopup = $(".skip-popup").find(".content-item-popup");
        if (contentPopup.length == 0) return;
        var numberRand = randomInteger(0, contentPopup.length - 1);
        $(contentPopup[numberRand]).removeClass("d-none");
        $(".skip-popup").css("display", "block");
        setTimeout(function () {
            $(".skip-popup").css("display", "none");
            $(contentPopup[numberRand]).addClass("d-none");
        }, 1500);
    };
    var showSuccessPopUp = function (argument) {
        var contentPopup = $(".success-popup").find(".content-item-popup");
        if (contentPopup.length == 0) return;
        var numberRand = randomInteger(0, contentPopup.length - 1);
        $(contentPopup[numberRand]).removeClass("d-none");
        $(".success-popup").css("display", "block");
        setTimeout(function () {
            $(".success-popup").css("display", "none");
            $(contentPopup[numberRand]).addClass("d-none");
        }, 1500);
    };
    var getCookie = function (cname) {
        var name = cname + "=";
        decodedCookie = document.cookie;
        var ca = decodedCookie.split(";");
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == " ") {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    };
    var setCookie = function (cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    };
    var initAudio = function (argument) {
        if (turnAudiorightWrongNotice == "false") {
            $("#switch_audio").addClass("muted");
            turnAudiorightWrongNotice = false;
        } else {
            $("#switch_audio").removeClass("muted");
            turnAudiorightWrongNotice = true;
        }
        $(".content-exam").ubaPlayer({
            audioButtonClass: "audio_ques",
            codecs: [{ name: "MP3", codec: "audio/mpeg;" }],
        });
    };
    var switchAudio = function () {
        if (turnAudio) {
            $(elm).addClass("muted");
        } else {
            $(elm).removeClass("muted");
        }
        turnAudio = !turnAudio;
        setCookie("switch_audio", turnAudio, 60);
    };
    var switchAudio = function (elm) {
        if (turnAudiorightWrongNotice) {
            $(elm).addClass("muted");
        } else {
            $(elm).removeClass("muted");
        }
        turnAudiorightWrongNotice = !turnAudiorightWrongNotice;
        setCookie("switch_audio", turnAudiorightWrongNotice, 60);
    };
    var plusPoint = function (dataExercises, questionIdx) {
        var currentPoint = dataExercises.exercises.current_point;
        var newPoint = currentPoint + dataExercises[questionIdx].point;
        dataExercises.exercises.current_point = newPoint;
        pointBox.html(newPoint);
    };
    var updateDataExercises = function (
        dataExercises,
        questionIdx,
        questionResult
    ) {
        if (questionResult) {
            plusPoint(dataExercises, questionIdx);
            dataExercises.exercises.total_true_question =
                dataExercises.exercises.total_true_question + 1;
            dataExercises[questionIdx].status = 1;
        }
    };
    var submitQuestion = function (elm) {
        var itemQuestion = $(elm).closest(".content-exam");
        var questionIdx = itemQuestion.attr("question");
        var statusDoQuestion = MODULE_QUESTION_EXERCISE.getQuestionDoStatus(
            dataExercises,
            questionIdx
        );
        if (!statusDoQuestion) {
            playClickAudio();
            $.confirm({
                closeIcon: true,
                columnClass:
                    "col-12 col-md-8 col-md-offset-4 col-lg-6 col-lg-offset-6",
                typeAnimated: true,
                title: `<p class="text-center">Em chưa làm xong câu này</>`,
                content: `<p class="text-center fz-20">Em có muốn tiếp tục làm không ?</p>`,
                buttons: {
                    continue: {
                        text: "Bỏ qua",
                        btnClass: "btn-info text-white px-3 px-lg-5 py-2 me-3",
                        action: function () {
                            playSkipques();
                            showSkipPopUp();
                            finishQuestion(
                                itemQuestion,
                                dataExercises,
                                questionIdx
                            );
                        },
                    },
                    cancel: {
                        text: "Làm tiếp",
                        btnClass: "btn-success px-3 px-lg-5 py-2",
                        action: function () {
                            playClickAudio();
                        },
                    },
                },
            });
            return;
        }
        var questionResult = MODULE_QUESTION_EXERCISE.checkQuestionResult(
            dataExercises,
            questionIdx
        );
        if (questionResult) {
            playCorrectAudio();
            showSuccessPopUp();
        } else {
            playIncorrectAudio();
            showFalsePopUp();
        }
        dataExercises[questionIdx].answer = MODULE_QUESTION_EXERCISE.getValue(
            dataExercises,
            questionIdx
        );
        finishQuestion(
            itemQuestion,
            dataExercises,
            questionIdx,
            questionResult
        );
        updateDataExercises(dataExercises, questionIdx, questionResult);
    };
    var changeQuestion = function (indexQuestion, playIndexAudioName = false) {
        playClickAudio();
        slideExam.slideTo(indexQuestion - 1, 0, false);
        setTimeout(function () {
            $(
                ".swiper-slide-active .content-exam .title-medium__all .play-audio"
            ).click();
        }, 100);
        $(".current-question-index").html(indexQuestion);
        $(".slide-question-number .number-question__exam").removeClass(
            "active"
        );
        $(
            ".slide-question-number .number-question__exam[index=" +
                indexQuestion +
                "]"
        ).addClass("active");
        $(
            ".slide-question-number .number-question__exam[index=" +
                indexQuestion +
                "]"
        ).attr(
            "onClick",
            "MODULE_EXERCISE.changeQuestion(" + indexQuestion + ",true)"
        );
    };
    var finishQuestion = function (
        itemQuestion,
        dataExercises,
        questionIdx,
        questionResult = undefined
    ) {
        dataExercises.exercises.total_question_done =
            dataExercises.exercises.total_question_done + 1;
        itemQuestion.find(".submit-result-exam").remove();
        itemQuestion.find(".show-result-exam").addClass("show");
        itemQuestion.find(".form-bottom").addClass("show");
        itemQuestion.find(".box_keyboard").slideUp(300);
        $(
            ".slide-question-number .number-question__exam[index=" +
                itemQuestion.attr("index") +
                "]"
        ).attr(
            "onClick",
            "MODULE_EXERCISE.changeQuestion(" +
                itemQuestion.attr("index") +
                ",true)"
        );
        MODULE_QUESTION_EXERCISE.disableAnswerQuestion(
            dataExercises,
            questionIdx
        );
        var boxStatusAnswerQuestion = itemQuestion.find(".answer_status_info");
        boxStatusAnswerQuestion.addClass("mt-2 mb-4 px-5 py-2 fz-18");
        if (typeof questionResult == "undefined") {
            boxStatusAnswerQuestion.addClass("btn-warning");
            boxStatusAnswerQuestion.html("Bạn đã bỏ qua câu hỏi này");
        } else {
            if (questionResult) {
                boxStatusAnswerQuestion.addClass("btn-success");
                boxStatusAnswerQuestion.html("Trả lời đúng");
            } else {
                boxStatusAnswerQuestion.addClass("btn-danger");
                boxStatusAnswerQuestion.html("Trả lời sai");
            }
        }
        if (
            dataExercises.exercises.total_question_done ==
            dataExercises.exercises.total_question
        ) {
            setTimeout(function () {
                _submitExercise();
            }, 1500);
        }
    };
    var _submitExercise = function () {
        $.ajax({
            url: "send-exercise-results",
            type: "POST",
            dataType: "json",
            data: { data: dataExercises },
        }).done(function (json) {
            if (typeof countDown != "undefined") {
                countDown.stop();
            }
            if (json.code == 200) {
                playFinishAudio();
                $.confirm({
                    closeIcon: true,
                    columnClass: "col-12 col-xl-8 col-xl-offset-4",
                    typeAnimated: true,
                    title: ` `,
                    content: json.html,
                    buttons: {
                        listExercise: {
                            text: '<i class="fa fa-list me-2" aria-hidden="true"></i> Danh sách bài tập',
                            btnClass:
                                "btn-green__all text-white px-3 py-2 me-3",
                            action: function () {
                                window.location.href = json.link_back;
                            },
                        },
                        redo: {
                            text: '<i class="fa fa-undo me-2" aria-hidden="true"></i> Làm lại',
                            btnClass: "btn btn-yellow__all py-2",
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
            } else {
                $.alert({
                    icon: "fa fa-warning",
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
    var initShowTutorialDetail = function () {
        $(document).on("click", ".btn-view-tutorial__detail", function (event) {
            event.preventDefault();
            $(this)
                .closest(".content-exam")
                .find(".tutorial__detail")
                .addClass("show");
            $(this).remove();
        });
    };
    return {
        _: function () {
            turnAudiorightWrongNotice = getCookie("switch_audio");
            initAudio();
            initCountDownTime();
            initPopupQuestionResultPosition();
            initSlideExam();
            initShowTutorialDetail();
            initClickKeyboard();
        },
        switchAudio(elm) {
            switchAudio(elm);
        },
        changeQuestion(indexQuestion) {
            changeQuestion(indexQuestion);
        },
        submitQuestion(elm) {
            submitQuestion(elm);
        },
        countDownDone(elm) {
            countDownDone(elm);
        },
    };
})();
$(document).ready(function () {
    MODULE_EXERCISE._();
});
