/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./packages/roniejisa/scripts/assets/js/Helper.js":
/*!********************************************************!*\
  !*** ./packages/roniejisa/scripts/assets/js/Helper.js ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var Helper = {
  convertDate: function convertDate(str) {
    var date = new Date(str),
        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
        day = ("0" + date.getDate()).slice(-2);
    return [date.getFullYear(), mnth, day].join("-");
  },
  number_format: function number_format(number) {
    var oneChar = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : ",";
    var twoChar = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : ".";
    return number != "" ? Intl.NumberFormat().format(number).replaceAll(oneChar, twoChar) : "";
  },
  limitString: function limitString(input) {
    var limit = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 10;
    var string = input.value;

    if (string.split("").length >= limit) {
      string = string.substring(0, limit);
    }

    return string;
  },
  inputNumber: function inputNumber(input) {
    var min = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
    var max = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : Infinity;
    var numberOrNull = input.value.trim() == "" ? null : input.value;

    if (numberOrNull == null) {
      return input.value = "";
    } else {
      var n = numberOrNull.toString().replaceAll(/[^\d]/g, "");

      if (n >= min && n <= max) {
        input.value = input.value;
      } else {
        input.value = n.slice(0, -1);
      }
    }

    return input.value;
  },
  nonAccentVietnamese: function nonAccentVietnamese(keyword) {
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {
      removeCharacter: false,
      upperCase: false,
      removeNumber: false,
      removeString: false
    };
    var defaultOption = {
      removeCharacter: false,
      upperCase: false,
      removeNumber: false,
      removeString: false
    };
    options = _objectSpread(_objectSpread({}, defaultOption), options);
    keyword = keyword.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    keyword = keyword.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    keyword = keyword.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    keyword = keyword.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    keyword = keyword.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    keyword = keyword.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    keyword = keyword.replace(/đ/g, "d");
    keyword = keyword.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, ""); // Huyền sắc hỏi ngã nặng

    keyword = keyword.replace(/\u02C6|\u0306|\u031B/g, ""); // Â, Ê, Ă, Ơ, Ư

    keyword = options.removeCharacter ? keyword.replace(/[^\w\s]/gi, "") : keyword;
    keyword = options.upperCase ? keyword.toUpperCase() : keyword;
    keyword = options.removeNumber ? keyword.replace(/[0-9]/g, "") : keyword;
    keyword = options.removeString ? keyword.replace(/[^a-zA-Z]/gi, "") : keyword;
    return keyword;
  },
  siblings: function siblings(elem) {
    //Tạo mảng rỗng
    var siblings = [];
    siblings.push(elem); //  Kiểm tra nếu không có cha thì return lại

    if (!elem.parentNode) {
      return siblings;
    } // Lấy ra phần tử đầu của mảng để đệ quy


    var sibling = elem.parentNode.firstElementChild; // Vòng lặp lấy ra đến khi null

    do {
      // Thêm element sibling vào mảng
      if (sibling != elem) {
        siblings.push(sibling);
      }
    } while (sibling = sibling.nextElementSibling);

    return siblings;
  },
  removeDuplicateTwoArrayObject: function removeDuplicateTwoArrayObject(arrayMain, arraySub, attr) {
    // Remove Object Sub In arrayMain
    var newArray = arrayMain.filter(function (objectMain) {
      return !arraySub.some(function (objectSub) {
        return objectMain[attr] == objectSub[attr];
      });
    }); // Get Attribute Main RemoveAttributeSub

    var getAttributeMain = newArray.map(function (item) {
      return item[attr];
    }); // Remove Duplicate

    newArray = newArray.filter(function (item, index) {
      return !getAttributeMain.includes(item[attr], index + 1);
    });
    return newArray;
  },
  removeSkeleton: function removeSkeleton() {
    var seleton = document.querySelectorAll("[skeleton-loading]");
    setTimeout(function () {
      seleton.forEach(function (item) {
        return item.removeAttribute("skeleton-loading");
      });
    }, 1000);
  },
  dataURLtoFile: function dataURLtoFile(base64, filename) {
    var arr = base64.split(",");
    if (arr[0] == "") return "";
    var mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]),
        n = bstr.length,
        u8arr = new Uint8Array(n);

    while (n--) {
      u8arr[n] = bstr.charCodeAt(n);
    }

    return new File([u8arr], filename, {
      type: mime
    });
  },
  clearDataForm: function clearDataForm(form) {
    var inputs = form.querySelectorAll("[name]");
    inputs.forEach(function (element) {
      switch (element.type) {
        case "checkbox":
        case "radio":
          element.checked = false;
          break;

        case "select-one":
          if (element.hasAttribute("clear-option")) {
            element.innerHTML = "<option value=\"\">".concat(element.getAttribute("clear-option"), "</option>");
          }

          element.selectedIndex = 0;
          break;

        case "hidden":
          break;

        default:
          element.value = "";
          break;
      }
    });
  },
  openNewWindow: function openNewWindow(link) {
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {
      "with": 400,
      height: 400
    };
    window.open(link, "_blank", "toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=".concat(options["with"], ", height=").concat(options.height));
  },
  callFunction: function callFunction(func) {
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : [];

    try {
      var arrayFunc = func.split(".");

      if (arrayFunc.length === 1 && null != window[arrayFunc[0]] && typeof window[arrayFunc[0]] === "function") {
        var _window;

        return null != window[arrayFunc[0]] && typeof window[arrayFunc[0]] === "function" && (_window = window)[arrayFunc[0]].apply(_window, _toConsumableArray(options));
      } else if (arrayFunc.length === 2) {
        var obj = arrayFunc[0];
        func = arrayFunc[1];
        var classEval = _typeof(eval("".concat(obj))) === "object" ? eval("".concat(obj)) : eval("new ".concat(obj, "()"));

        if (_typeof(classEval) === "object" && typeof classEval[func] === "function") {
          return typeof classEval[func] === "function" && classEval[func].apply(classEval, _toConsumableArray(options));
        } else if (window[obj] === "object" && typeof window[obj][func] === "function") {
          var _window$obj;

          return window[obj] === "object" && typeof window[obj][func] === "function" && (_window$obj = window[obj])[func].apply(_window$obj, _toConsumableArray(options));
        }
      }
    } catch (err) {
      console.log(err);
      alert("Sửa lại data-success, Chưa đúng định dạng Object Function hoặc Class Function");
    }
  },
  humanFileSize: function humanFileSize(B) {
    var i = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
    var e = i ? 1e3 : 1024;
    if (Math.abs(B) < e) return B + " B";
    var a = i ? ["kB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"] : ["KiB", "MiB", "GiB", "TiB", "PiB", "EiB", "ZiB", "YiB"],
        t = -1;

    do {
      B /= e, ++t;
    } while (Math.abs(B) >= e && t < a.length - 1);

    return B.toFixed(1) + " " + a[t];
  },
  copyToClipboard: function copyToClipboard(text) {
    var textarea = document.createElement("textarea");
    textarea.textContent = text;
    document.body.appendChild(textarea);
    var selection = document.getSelection();
    var range = document.createRange();
    range.selectNode(textarea);
    selection.removeAllRanges();
    selection.addRange(range);
    document.execCommand("copy");
    selection.removeAllRanges();
    document.body.removeChild(textarea);
  },
  toHHMMSS: function toHHMMSS(sec_num) {
    var hours = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - hours * 3600) / 60);
    var seconds = sec_num - hours * 3600 - minutes * 60;

    if (hours < 10) {
      hours = "0" + hours;
    }

    if (minutes < 10) {
      minutes = "0" + minutes;
    }

    if (seconds < 10) {
      seconds = "0" + Math.floor(Math.round(seconds * 10) / 10).toFixed(0);
    }

    if (Number(hours) > 0 && Number(minutes) > 0) {
      return hours + ":" + minutes + ":" + seconds;
    } else {
      return minutes + ":" + seconds;
    }
  }
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Helper);

/***/ }),

/***/ "./packages/tech5s/video-chapter/resources/js/ImageVideo.js":
/*!******************************************************************!*\
  !*** ./packages/tech5s/video-chapter/resources/js/ImageVideo.js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ getImageOfVideo)
/* harmony export */ });
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return generator._invoke = function (innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; }(innerFn, self, context), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; this._invoke = function (method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); }; } function maybeInvokeDelegate(delegate, context) { var method = delegate.iterator[context.method]; if (undefined === method) { if (context.delegate = null, "throw" === context.method) { if (delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method)) return ContinueSentinel; context.method = "throw", context.arg = new TypeError("The iterator does not provide a 'throw' method"); } return ContinueSentinel; } var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) { if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; } return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, define(Gp, "constructor", GeneratorFunctionPrototype), define(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (object) { var keys = []; for (var key in object) { keys.push(key); } return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) { "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); } }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var getImageOfVideo = /*#__PURE__*/_createClass(function getImageOfVideo(path, secs, callback) {
  var _this = this;

  var data = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : [];

  _classCallCheck(this, getImageOfVideo);

  _defineProperty(this, "init", function () {
    _this.video.onloadedmetadata = function () {
      if ("function" === typeof _this.secs) {
        _this.secs = _this.secs(_this.video.duration);
      }

      _this.video.currentTime = Math.min(Math.max(0, (_this.secs < 0 ? _this.video.duration : 0) + _this.secs), _this.video.duration);
    };

    _this.video.onseeked = function (e) {
      var _this$callback;

      var canvas = document.createElement("canvas");
      canvas.height = _this.video.videoHeight;
      canvas.width = _this.video.videoWidth;
      var ctx = canvas.getContext("2d");
      ctx.drawImage(_this.video, 0, 0, canvas.width, canvas.height);
      _this.url = canvas.toDataURL();

      (_this$callback = _this.callback).call.apply(_this$callback, [_this, _this.url].concat(_toConsumableArray(_this.data), [_this.video.duration]));
    };

    _this.video.onerror = function (e) {
      var _this$callback2;

      (_this$callback2 = _this.callback).call.apply(_this$callback2, [_this, e].concat(_toConsumableArray(_this.data), [_this.video.duration]));
    };

    _this.video.src = _this.path;
  });

  _defineProperty(this, "getUrl", /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
    return _regeneratorRuntime().wrap(function _callee$(_context) {
      while (1) {
        switch (_context.prev = _context.next) {
          case 0:
            setTimeout(function () {
              return _this.url;
            }, 2000);

          case 1:
          case "end":
            return _context.stop();
        }
      }
    }, _callee);
  })));

  this.callback = callback;
  this.data = data;
  this.path = path;
  this.secs = secs;
  this.video = document.createElement("video");
});



/***/ }),

/***/ "./packages/tech5s/video-chapter/resources/js/video.js":
/*!*************************************************************!*\
  !*** ./packages/tech5s/video-chapter/resources/js/video.js ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ImageVideo_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ImageVideo.js */ "./packages/tech5s/video-chapter/resources/js/ImageVideo.js");
/* harmony import */ var _roniejisa_scripts_assets_js_Helper_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./../../../../roniejisa/scripts/assets/js/Helper.js */ "./packages/roniejisa/scripts/assets/js/Helper.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return generator._invoke = function (innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; }(innerFn, self, context), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; this._invoke = function (method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); }; } function maybeInvokeDelegate(delegate, context) { var method = delegate.iterator[context.method]; if (undefined === method) { if (context.delegate = null, "throw" === context.method) { if (delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method)) return ContinueSentinel; context.method = "throw", context.arg = new TypeError("The iterator does not provide a 'throw' method"); } return ContinueSentinel; } var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) { if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; } return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, define(Gp, "constructor", GeneratorFunctionPrototype), define(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (object) { var keys = []; for (var key in object) { keys.push(key); } return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) { "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); } }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _asyncIterator(iterable) { var method, async, sync, retry = 2; for ("undefined" != typeof Symbol && (async = Symbol.asyncIterator, sync = Symbol.iterator); retry--;) { if (async && null != (method = iterable[async])) return method.call(iterable); if (sync && null != (method = iterable[sync])) return new AsyncFromSyncIterator(method.call(iterable)); async = "@@asyncIterator", sync = "@@iterator"; } throw new TypeError("Object is not async iterable"); }

function AsyncFromSyncIterator(s) { function AsyncFromSyncIteratorContinuation(r) { if (Object(r) !== r) return Promise.reject(new TypeError(r + " is not an object.")); var done = r.done; return Promise.resolve(r.value).then(function (value) { return { value: value, done: done }; }); } return AsyncFromSyncIterator = function AsyncFromSyncIterator(s) { this.s = s, this.n = s.next; }, AsyncFromSyncIterator.prototype = { s: null, n: null, next: function next() { return AsyncFromSyncIteratorContinuation(this.n.apply(this.s, arguments)); }, "return": function _return(value) { var ret = this.s["return"]; return void 0 === ret ? Promise.resolve({ value: value, done: !0 }) : AsyncFromSyncIteratorContinuation(ret.apply(this.s, arguments)); }, "throw": function _throw(value) { var thr = this.s["return"]; return void 0 === thr ? Promise.reject(value) : AsyncFromSyncIteratorContinuation(thr.apply(this.s, arguments)); } }, new AsyncFromSyncIterator(s); }




var ListVideoChaptr = /*#__PURE__*/function () {
  function ListVideoChaptr(table) {
    var _this = this;

    _classCallCheck(this, ListVideoChaptr);

    _defineProperty(this, "init", function () {
      _this.listMain = _this.table.querySelector("[list-items]");
      _this.listItems = _this.listMain.querySelectorAll("[item]");
      _this.btnAddItem = _this.table.querySelector("[add-item]");
      _this.btnAddItem.onclick = _this.addHTML;
    });

    _defineProperty(this, "addHTML", /*#__PURE__*/function () {
      var _ref = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(e) {
        var item, _iteratorAbruptCompletion, _didIteratorError, _iteratorError, _iterator, _step, field, id, close;

        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                item = document.createElement("div");
                item.className = "col-span-1 border border-[#212529] p-2 relative";
                item.setAttribute("item", "");
                _iteratorAbruptCompletion = false;
                _didIteratorError = false;
                _context.prev = 5;
                _iterator = _asyncIterator(_this.fields);

              case 7:
                _context.next = 9;
                return _iterator.next();

              case 9:
                if (!(_iteratorAbruptCompletion = !(_step = _context.sent).done)) {
                  _context.next = 16;
                  break;
                }

                field = _step.value;
                id = _this.nameTable + "-" + _this.makeId(6);
                item.innerHTML += _this.getHTMLType(field, id);

              case 13:
                _iteratorAbruptCompletion = false;
                _context.next = 7;
                break;

              case 16:
                _context.next = 22;
                break;

              case 18:
                _context.prev = 18;
                _context.t0 = _context["catch"](5);
                _didIteratorError = true;
                _iteratorError = _context.t0;

              case 22:
                _context.prev = 22;
                _context.prev = 23;

                if (!(_iteratorAbruptCompletion && _iterator["return"] != null)) {
                  _context.next = 27;
                  break;
                }

                _context.next = 27;
                return _iterator["return"]();

              case 27:
                _context.prev = 27;

                if (!_didIteratorError) {
                  _context.next = 30;
                  break;
                }

                throw _iteratorError;

              case 30:
                return _context.finish(27);

              case 31:
                return _context.finish(22);

              case 32:
                close = document.createElement("button");
                close.type = "button";
                close.innerHTML = '<i class="fa fa-times" aria-hidden="true"></i>';
                close.classList = "absolute top-1 right-1 bg-orange-500 text-white h-10 w-10";
                close.setAttribute("remove-item", "");

                close.onclick = function () {
                  item.remove();

                  _this.updateAll();
                };

                item.append(close);

                _this.listMain.append(item);

                _this.addEventChange(); //Xóa file


                _this.removeFile();

              case 42:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, null, [[5, 18, 22, 32], [23,, 27, 31]]);
      }));

      return function (_x) {
        return _ref.apply(this, arguments);
      };
    }());

    _defineProperty(this, "addEventChange", function () {
      _this.listMain.querySelectorAll("[data-name]").forEach(function (input) {
        input.onchange = function () {
          _this.updateAll();
        };
      });
    });

    _defineProperty(this, "removeFile", function () {
      _this.btnRemoveFiles = _this.listMain.querySelectorAll("[remove-file]");

      _this.btnRemoveFiles.forEach(function (button) {
        button.onclick = function () {
          var id = button.getAttribute("remove-file");
          var div = document.querySelector("[data-id=\"".concat(id, "\"]"));
          var img = div.querySelector("img");
          img.src = "/admin/images/noimage.png";

          if (img.hasAttribute("data-blob")) {
            var blob = img.dataset.blob;
            window.URL.revokeObjectURL(blob);
            img.removeAttribute("data-blob");
          }

          var input = div.querySelector("input[id=\"".concat(id, "\"]"));
          input.value = "";

          _this.updateAll();
        };
      });
    });

    _defineProperty(this, "updateAll", function () {
      _this.raw = [];

      _this.listMain.querySelectorAll("[item]").forEach(function (item) {
        var dataFields = item.querySelectorAll("[data-name]");
        var dataItem = {};
        dataFields.forEach(function (data) {
          dataItem[data.dataset.name] = data.value;
        });

        _this.raw.push(dataItem);
      });

      _this.inputRaw.innerHTML = JSON.stringify(_this.raw);
    });

    _defineProperty(this, "changeDataImageOld", function () {
      _this.raw = [];

      _this.listMain.querySelectorAll("[item] img").forEach(function (img) {
        var coponentImg = img.closest("[data-id]");
        var id = coponentImg.dataset.id;
        var media = JSON.parse(coponentImg.querySelector("input").value);
        var request = new XMLHttpRequest();
        request.open("GET", img.src, true);
        request.responseType = "blob";

        request.onload = function () {
          var reader = new FileReader();
          reader.readAsDataURL(request.response);

          reader.onload = function (e) {
            var base64 = e.target.result;
            var mimeType = base64.match(/[^:/]\w+(?=;|,)/)[0];
            var path = _roniejisa_scripts_assets_js_Helper_js__WEBPACK_IMPORTED_MODULE_1__["default"].dataURLtoFile(base64, mimeType);
            var blob = window.URL.createObjectURL(path);
            img.setAttribute("data-blob", blob);
            new _ImageVideo_js__WEBPACK_IMPORTED_MODULE_0__["default"](blob, 1, videoUpload, [id, media]).init();
          };
        };

        request.send();
      });

      _this.removeItem();

      _this.removeFile();

      _this.addEventChange();
    });

    _defineProperty(this, "getHTMLType", function (field, id) {
      var html;

      switch (field.type) {
        case "text":
          html = "\n                    <div>\n                        <label htmlFor=\"\">".concat(field.label, "</label>\n                        <input type=\"text\" class=\"").concat(_this.styleInput, "\" placeholder=\"").concat(field.placeholder, "\" data-name=\"").concat(field.name, "\"/>\n                    </div>\n                ");
          break;

        case "file":
          html = "\n                    <div data-id=\"".concat(id, "\">\n                        <label htmlFor=\"\">").concat(field.label, "</label>\n                        <input type=\"hidden\" id=\"").concat(id, "\" data-name=\"").concat(field.name, "\" />\n                        <input type=\"hidden\" data-name=\"duration\"/>\n                        <a href=\"/esystem/media/view?istiny=").concat(id, "&callback=VIDEO_CHAPTER.callbackFile\" class=\"iframe-btn\">\n                            <img src=\"/admin/images/noimage.png\" alt=\"\" class=\"w-full h-auto\" />\n                        </a>\n                        <div class=\"mt-3 gap-2 grid grid-cols-2\">\n                            <a class=\"text-center text-white p-2 w-full bg-blue-600 col-span-1 iframe-btn\" href=\"/esystem/media/view?istiny=").concat(id, "&callback=VIDEO_CHAPTER.callbackFile\" type=\"button\">").concat(field.placeholder, "</a>\n                            <a class=\"text-center text-white p-2 w-full bg-red-600 col-span-1\" href=\"javascript:void(0)\" remove-file=\"").concat(id, "\" >X\xF3a</a>\n                        </div>\n                    </div>\n                ");
          break;

        case "select":
          html = "\n                <label htmlFor=\"\">".concat(field.label, "</label>\n                <select data-name=\"").concat(field.name, "\" class=\"").concat(_this.styleInput, "\">\n                    ").concat(field.options.map(function (option) {
            return "<option value=\"".concat(option.value, "\">").concat(option.name, "</option>");
          }).join(""), "\n                </select>\n                ");
          break;

        case "hidden":
          html = "<input type=\"hidden\" data-name=\"".concat(field.name, "\">");
          break;

        case "":
          break;
      }

      return html;
    });

    _defineProperty(this, "addItem", function () {});

    _defineProperty(this, "makeId", function (length) {
      var result = "";
      var characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      var charactersLength = characters.length;

      for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
      }

      return result;
    });

    this.table = table;
    this.nameTable = this.table.getAttribute("tech5s-video-chapter");
    this.fields = JSON.parse(this.table.getAttribute("field-list"));
    this.inputRaw = this.table.querySelector("textarea[name=\"".concat(this.nameTable, "\"]"));
    this.init();
    this.addItem();
    this.styleInput = "w-full px-2 py-1 border";
    this.changeDataImageOld();
    this.updateAll();
  }

  _createClass(ListVideoChaptr, [{
    key: "removeItem",
    value: function removeItem() {
      var _this2 = this;

      this.btnRemoveFiles = this.listMain.querySelectorAll("[remove-item]");
      this.btnRemoveFiles.forEach(function (button) {
        button.onclick = function () {
          var item = button.closest("[item]");
          var img = item.querySelector("img");

          if (img.hasAttribute("data-blob")) {
            window.URL.revokeObjectURL(img.dataset.blob);
          }

          item.remove();

          _this2.updateAll();
        };
      });
    }
  }]);

  return ListVideoChaptr;
}();

window.addEventListener("DOMContentLoaded", function () {
  (function () {
    var init = function init() {
      var tables = document.querySelectorAll("[tech5s-video-chapter]");
      tables.forEach(function (table, index) {
        new ListVideoChaptr(table);
      });
    };

    return {
      load: function () {
        init();
      }()
    };
  })();
});

window["VIDEO_CHAPTER"] = function () {
  return {
    callbackFile: function callbackFile(items, id) {
      var media = items[0];
      var img = document.querySelector("[data-id=\"".concat(id, "\"] img"));
      var request = new XMLHttpRequest();
      var urlOrigin = window.location.origin + "/";
      request.open("GET", urlOrigin + media.path + media.file_name, true);
      request.responseType = "blob";

      request.onload = function () {
        var reader = new FileReader();
        reader.readAsDataURL(request.response);

        reader.onload = function (e) {
          var base64 = e.target.result;
          var mimeType = base64.match(/[^:/]\w+(?=;|,)/)[0];
          var path = _roniejisa_scripts_assets_js_Helper_js__WEBPACK_IMPORTED_MODULE_1__["default"].dataURLtoFile(base64, mimeType);
          var blob = window.URL.createObjectURL(path);
          img.setAttribute("data-blob", blob);
          new _ImageVideo_js__WEBPACK_IMPORTED_MODULE_0__["default"](blob, 1, videoUpload, [id, media]).init();
        };
      };

      request.send();
    }
  };
}();

var videoUpload = function videoUpload(base64img, id, jsonFile, duration) {
  var div = document.querySelector("[data-id=\"".concat(id, "\"]"));
  var image = div.querySelector("img");
  var input = div.querySelector("input[id=\"".concat(id, "\"]"));
  input.nextElementSibling.value = duration;
  input.value = JSON.stringify(jsonFile);
  image.src = base64img;
  input.dispatchEvent(new Event("change"));
};

/***/ }),

/***/ "./packages/roniejisa/comment/resources/style/app.css":
/*!************************************************************!*\
  !*** ./packages/roniejisa/comment/resources/style/app.css ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./packages/tech5s/promotion/resources/css/app.css":
/*!*********************************************************!*\
  !*** ./packages/tech5s/promotion/resources/css/app.css ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./packages/tech5s/video-chapter/resources/css/video.css":
/*!***************************************************************!*\
  !*** ./packages/tech5s/video-chapter/resources/css/video.css ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/css/app.css":
/*!*******************************!*\
  !*** ./resources/css/app.css ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/video/js/video": 0,
/******/ 			"css/app": 0,
/******/ 			"video/css/video": 0,
/******/ 			"admin/promotion/css/app": 0,
/******/ 			"comment/style/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app","video/css/video","admin/promotion/css/app","comment/style/app"], () => (__webpack_require__("./packages/tech5s/video-chapter/resources/js/video.js")))
/******/ 	__webpack_require__.O(undefined, ["css/app","video/css/video","admin/promotion/css/app","comment/style/app"], () => (__webpack_require__("./packages/roniejisa/comment/resources/style/app.css")))
/******/ 	__webpack_require__.O(undefined, ["css/app","video/css/video","admin/promotion/css/app","comment/style/app"], () => (__webpack_require__("./packages/tech5s/promotion/resources/css/app.css")))
/******/ 	__webpack_require__.O(undefined, ["css/app","video/css/video","admin/promotion/css/app","comment/style/app"], () => (__webpack_require__("./packages/tech5s/video-chapter/resources/css/video.css")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app","video/css/video","admin/promotion/css/app","comment/style/app"], () => (__webpack_require__("./resources/css/app.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;