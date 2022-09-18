/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************!*\
  !*** ./resources/js/question.js ***!
  \**********************************/
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var commentRS = /*#__PURE__*/_createClass(function commentRS(model, label, tableLike, fieldMain, withParam) {
  var _this = this;

  _classCallCheck(this, commentRS);

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

        listChild.insertAdjacentHTML("beforeend", "<form action=\"reply-cau-hoi\" absolute clear class=\"form-validate\" data-success=\"ASK_AND_ANSWER.showNotifyRemoveForm\" method=\"POST\">\n                        <input type=\"hidden\" name=\"_token\" value=\"".concat(document.querySelector("meta[name='csrf-token']").getAttribute("content"), "\" />\n                        <input  type=\"hidden\" name=\"id\" value=\"").concat(button.dataset.id, "\" />\n                        <input type=\"hidden\" name=\"field_main\" value=\"").concat(_this.fieldMain, "\" />\n                        <input type=\"hidden\" name=\"model\" value=\"").concat(_this.model, "\">\n                        <input type=\"hidden\" name=\"label\" value=\"").concat(_this.label, "\">\n                        <div class=\"flex items-center p-3 rounded-md shadow-lg gap-2\">\n                            <textarea class=\"flex-1 outline-none p-2 h-[38px] bg-transparent\" rules=\"required\" name=\"content\" placeholder=\"C\xE2u tr\u1EA3 l\u1EDDi\"></textarea>\n                            <button type=\"submit\" class=\"btn btn-red-gradien inline-flex items-center justify-center rounded bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-4 font-semibold text-white\">Tr\u1EA3 l\u1EDDi</button>\n                        </div>\n                    </form>"));
        listChild.querySelector("textarea").focus();
        VALIDATE_FORM.refresh();
      };
    });
  });

  _defineProperty(this, "nextPage", function () {
    var nextPage = document.querySelector("[ask-load-more]");
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
          "with": _this["with"]
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

  this.fieldMain = fieldMain;
  this.model = model;
  this.label = label;
  this.tableLike = tableLike;
  this["with"] = withParam;
  this.like();
  this.reply();
  this.nextPage();
});

window["ASK_AND_ANSWER"] = function () {
  return {
    _: function () {
      new commentRS("\\App\\Models\\AskAndAnswer", "Câu hỏi", "ask_and_answer_user", "ask_and_answer_id", "likes,asks");
      new commentRS("\\App\\Models\\AskAndAnswer", "Câu hỏi", "ask_and_answer_user", "ask_and_answer_id", "likes,asks");
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