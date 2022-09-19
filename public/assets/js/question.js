/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************!*\
  !*** ./resources/js/question.js ***!
  \**********************************/
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var commentRS = /*#__PURE__*/_createClass(function commentRS(_selector, model, label, tableLike, fieldMain, withParam, view) {
  var _this = this;

  _classCallCheck(this, commentRS);

  _defineProperty(this, "filter", function () {
    _this.selectors.forEach(function (selector) {
      var listFilters = selector.querySelectorAll("[rs-qaa-filter]");
      listFilters.forEach(function (filter) {
        filter.onchange = function () {
          var fomrData = new FormDataRS("", false);

          var data = _objectSpread({
            model: _this.model,
            label: _this.label,
            "with": _this["with"],
            view: _this.view
          }, fomrData.buildData(listFilters, "input"));

          XHR.send({
            url: "loc-cau-hoi",
            method: "POST",
            data: data
          }).then(function (res) {
            selector.querySelectorAll("[item]").forEach(function (item) {
              item.remove();
            });
            var listData = selector.querySelector("[list-data]");

            if (res.isLastPage == true) {
              if (listData.querySelector("[ask-load-more]")) {
                listData.querySelector("[ask-load-more]").remove();
                listData.innerHTML = res.html;
              }
            } else {
              if (listData.querySelector("[ask-load-more]")) {
                listData.querySelector("[ask-load-more]").insertAdjacentHTML("beforeend", res.html);
              } else {
                listData.innerHTML = res.html;
              }
            }

            _this.like();

            _this.reply();

            _this.filter();

            _this.nextPage();
          });
        };
      });
    });
  });

  _defineProperty(this, "like", function () {
    var likeButtons = document.querySelectorAll("[rs-qaa-like]");
    likeButtons.forEach(function (button) {
      button.onclick = function () {
        var id = button.dataset.id;
        XHR.send({
          url: "thich-cau-hoi",
          method: "POST",
          data: {
            id: id,
            model: _this.model,
            label: _this.label,
            table_like: _this.tableLike,
            field_main: _this.fieldMain
          }
        }).then(function (res) {
          if (res.code == 200) {
            !button.classList.contains("like") && button.classList.add("like");
          } else if (res.code == 100) {
            button.classList.contains("like") && button.classList.remove("like");
          }

          NOTIFICATION.showNotify(res.code, res.message);
        });
      };
    });
  });

  _defineProperty(this, "reply", function () {
    var replyAsk = document.querySelectorAll("[rs-qaa-reply]");
    replyAsk.forEach(function (button) {
      button.onclick = function () {
        var parentElement = button.parentElement;
        var listChild = parentElement.querySelector("[rs-qaa-list-child]");

        if (listChild.querySelector("form")) {
          listChild.querySelector("form").remove();
          return;
        }

        listChild.insertAdjacentHTML("beforeend", "<form action=\"reply-cau-hoi\" absolute clear class=\"form-validate\" data-success=\"ASK_AND_ANSWER.showNotifyRemoveForm\" method=\"POST\">\n                        <input type=\"hidden\" name=\"_token\" value=\"".concat(document.querySelector("meta[name='csrf-token']").getAttribute("content"), "\" />\n                        <input  type=\"hidden\" name=\"id\" value=\"").concat(button.dataset.id, "\" />\n                        <input type=\"hidden\" name=\"field_main\" value=\"").concat(_this.fieldMain, "\" />\n                        <input type=\"hidden\" name=\"model\" value=\"").concat(_this.model, "\">\n                        <input type=\"hidden\" name=\"label\" value=\"").concat(_this.label, "\">\n                        <div class=\"flex items-center p-3 rounded-md shadow-lg gap-2\">\n                            <textarea class=\"flex-1 outline-none p-2 h-[38px] bg-transparent resize-none rules=\"required\" name=\"content\" placeholder=\"C\xE2u tr\u1EA3 l\u1EDDi\"></textarea>\n                            <button type=\"submit\" class=\"btn btn-red-gradien inline-flex items-center justify-center rounded bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-4 font-semibold text-white\">Tr\u1EA3 l\u1EDDi</button>\n                        </div>\n                    </form>"));
        listChild.querySelector("textarea").focus();
        VALIDATE_FORM.refresh();
      };
    });
  });

  _defineProperty(this, "nextPage", function () {
    _this.selectors.forEach(function (selector) {
      var nextPage = selector.querySelector("[ask-load-more]");
      if (!nextPage) return;

      nextPage.onclick = function () {
        XHR.send({
          url: "tai-them-cau-hoi",
          method: "GET",
          data: {
            model: _this.model,
            label: _this.label,
            map_table: nextPage.dataset.table,
            map_id: nextPage.dataset.id,
            page: nextPage.dataset.nextPage,
            "with": _this["with"],
            view: _this.view
          }
        }).then(function (res) {
          nextPage.insertAdjacentHTML("beforebegin", res.html);

          if (res.isLastPage) {
            nextPage.remove();
          }

          _this.like();

          _this.reply();
        });
      };
    });
  });

  this.selectors = document.querySelectorAll(_selector);
  if (this.selectors.length == 0) return;
  this.fieldMain = fieldMain;
  this.model = model;
  this.label = label;
  this.tableLike = tableLike;
  this["with"] = withParam;
  this.view = view;
  this.like();
  this.reply();
  this.filter();
  this.nextPage();
});

window["ASK_AND_ANSWER"] = function () {
  return {
    _: function () {
      new commentRS("[ask-selector]", "\\App\\Models\\AskAndAnswer", "câu hỏi", "ask_and_answer_user", "ask_and_answer_id", "likes,asks", "courses.components.ask_item");
      new commentRS("[question-teacher-main]", "\\App\\Models\\QuestionTeacher", "câu hỏi cho giảng viên", "question_teacher_user", "question_teacher_id", "likes,questions", "components.question_item");
    }(),
    showNotify: function showNotify(res) {
      NOTIFICATION.showNotify(res.code, res.message);
    },
    showNotifyRemoveForm: function showNotifyRemoveForm(res, data, form) {
      NOTIFICATION.showNotify(res.code, res.message);
      form.remove();
    }
  };
}();
/******/ })()
;