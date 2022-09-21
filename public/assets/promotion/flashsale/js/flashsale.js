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
function _typeof(obj) {
  "@babel/helpers - typeof";

  return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) {
    return typeof obj;
  } : function (obj) {
    return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
  }, _typeof(obj);
}

function _toConsumableArray(arr) {
  return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread();
}

function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return _arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}

function _iterableToArray(iter) {
  if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter);
}

function _arrayWithoutHoles(arr) {
  if (Array.isArray(arr)) return _arrayLikeToArray(arr);
}

function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) {
    arr2[i] = arr[i];
  }

  return arr2;
}

function ownKeys(object, enumerableOnly) {
  var keys = Object.keys(object);

  if (Object.getOwnPropertySymbols) {
    var symbols = Object.getOwnPropertySymbols(object);
    enumerableOnly && (symbols = symbols.filter(function (sym) {
      return Object.getOwnPropertyDescriptor(object, sym).enumerable;
    })), keys.push.apply(keys, symbols);
  }

  return keys;
}

function _objectSpread(target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = null != arguments[i] ? arguments[i] : {};
    i % 2 ? ownKeys(Object(source), !0).forEach(function (key) {
      _defineProperty(target, key, source[key]);
    }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) {
      Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key));
    });
  }

  return target;
}

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

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

/***/ "./packages/tech5s/flashsale/resources/js/flashsale.js":
/*!*************************************************************!*\
  !*** ./packages/tech5s/flashsale/resources/js/flashsale.js ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _roniejisa_scripts_assets_js_Helper__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../roniejisa/scripts/assets/js/Helper */ "./packages/roniejisa/scripts/assets/js/Helper.js");


function _typeof(obj) {
  "@babel/helpers - typeof";

  return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) {
    return typeof obj;
  } : function (obj) {
    return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
  }, _typeof(obj);
}

function _regeneratorRuntime() {
  "use strict";
  /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */

  _regeneratorRuntime = function _regeneratorRuntime() {
    return exports;
  };

  var exports = {},
      Op = Object.prototype,
      hasOwn = Op.hasOwnProperty,
      $Symbol = "function" == typeof Symbol ? Symbol : {},
      iteratorSymbol = $Symbol.iterator || "@@iterator",
      asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator",
      toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  function define(obj, key, value) {
    return Object.defineProperty(obj, key, {
      value: value,
      enumerable: !0,
      configurable: !0,
      writable: !0
    }), obj[key];
  }

  try {
    define({}, "");
  } catch (err) {
    define = function define(obj, key, value) {
      return obj[key] = value;
    };
  }

  function wrap(innerFn, outerFn, self, tryLocsList) {
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator,
        generator = Object.create(protoGenerator.prototype),
        context = new Context(tryLocsList || []);
    return generator._invoke = function (innerFn, self, context) {
      var state = "suspendedStart";
      return function (method, arg) {
        if ("executing" === state) throw new Error("Generator is already running");

        if ("completed" === state) {
          if ("throw" === method) throw arg;
          return doneResult();
        }

        for (context.method = method, context.arg = arg;;) {
          var delegate = context.delegate;

          if (delegate) {
            var delegateResult = maybeInvokeDelegate(delegate, context);

            if (delegateResult) {
              if (delegateResult === ContinueSentinel) continue;
              return delegateResult;
            }
          }

          if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) {
            if ("suspendedStart" === state) throw state = "completed", context.arg;
            context.dispatchException(context.arg);
          } else "return" === context.method && context.abrupt("return", context.arg);
          state = "executing";
          var record = tryCatch(innerFn, self, context);

          if ("normal" === record.type) {
            if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue;
            return {
              value: record.arg,
              done: context.done
            };
          }

          "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg);
        }
      };
    }(innerFn, self, context), generator;
  }

  function tryCatch(fn, obj, arg) {
    try {
      return {
        type: "normal",
        arg: fn.call(obj, arg)
      };
    } catch (err) {
      return {
        type: "throw",
        arg: err
      };
    }
  }

  exports.wrap = wrap;
  var ContinueSentinel = {};

  function Generator() {}

  function GeneratorFunction() {}

  function GeneratorFunctionPrototype() {}

  var IteratorPrototype = {};
  define(IteratorPrototype, iteratorSymbol, function () {
    return this;
  });
  var getProto = Object.getPrototypeOf,
      NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype);
  var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype);

  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function (method) {
      define(prototype, method, function (arg) {
        return this._invoke(method, arg);
      });
    });
  }

  function AsyncIterator(generator, PromiseImpl) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);

      if ("throw" !== record.type) {
        var result = record.arg,
            value = result.value;
        return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) {
          invoke("next", value, resolve, reject);
        }, function (err) {
          invoke("throw", err, resolve, reject);
        }) : PromiseImpl.resolve(value).then(function (unwrapped) {
          result.value = unwrapped, resolve(result);
        }, function (error) {
          return invoke("throw", error, resolve, reject);
        });
      }

      reject(record.arg);
    }

    var previousPromise;

    this._invoke = function (method, arg) {
      function callInvokeWithMethodAndArg() {
        return new PromiseImpl(function (resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg();
    };
  }

  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];

    if (undefined === method) {
      if (context.delegate = null, "throw" === context.method) {
        if (delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method)) return ContinueSentinel;
        context.method = "throw", context.arg = new TypeError("The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);
    if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel;
    var info = record.arg;
    return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel);
  }

  function pushTryEntry(locs) {
    var entry = {
      tryLoc: locs[0]
    };
    1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal", delete record.arg, entry.completion = record;
  }

  function Context(tryLocsList) {
    this.tryEntries = [{
      tryLoc: "root"
    }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0);
  }

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) return iteratorMethod.call(iterable);
      if ("function" == typeof iterable.next) return iterable;

      if (!isNaN(iterable.length)) {
        var i = -1,
            next = function next() {
          for (; ++i < iterable.length;) {
            if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next;
          }

          return next.value = undefined, next.done = !0, next;
        };

        return next.next = next;
      }
    }

    return {
      next: doneResult
    };
  }

  function doneResult() {
    return {
      value: undefined,
      done: !0
    };
  }

  return GeneratorFunction.prototype = GeneratorFunctionPrototype, define(Gp, "constructor", GeneratorFunctionPrototype), define(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) {
    var ctor = "function" == typeof genFun && genFun.constructor;
    return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name));
  }, exports.mark = function (genFun) {
    return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun;
  }, exports.awrap = function (arg) {
    return {
      __await: arg
    };
  }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () {
    return this;
  }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) {
    void 0 === PromiseImpl && (PromiseImpl = Promise);
    var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl);
    return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) {
      return result.done ? result.value : iter.next();
    });
  }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () {
    return this;
  }), define(Gp, "toString", function () {
    return "[object Generator]";
  }), exports.keys = function (object) {
    var keys = [];

    for (var key in object) {
      keys.push(key);
    }

    return keys.reverse(), function next() {
      for (; keys.length;) {
        var key = keys.pop();
        if (key in object) return next.value = key, next.done = !1, next;
      }

      return next.done = !0, next;
    };
  }, exports.values = values, Context.prototype = {
    constructor: Context,
    reset: function reset(skipTempReset) {
      if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) {
        "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined);
      }
    },
    stop: function stop() {
      this.done = !0;
      var rootRecord = this.tryEntries[0].completion;
      if ("throw" === rootRecord.type) throw rootRecord.arg;
      return this.rval;
    },
    dispatchException: function dispatchException(exception) {
      if (this.done) throw exception;
      var context = this;

      function handle(loc, caught) {
        return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i],
            record = entry.completion;
        if ("root" === entry.tryLoc) return handle("end");

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc"),
              hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0);
            if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc);
          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0);
          } else {
            if (!hasFinally) throw new Error("try statement without catch or finally");
            if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc);
          }
        }
      }
    },
    abrupt: function abrupt(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];

        if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null);
      var record = finallyEntry ? finallyEntry.completion : {};
      return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record);
    },
    complete: function complete(record, afterLoc) {
      if ("throw" === record.type) throw record.arg;
      return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel;
    },
    finish: function finish(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel;
      }
    },
    "catch": function _catch(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];

        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;

          if ("throw" === record.type) {
            var thrown = record.arg;
            resetTryEntry(entry);
          }

          return thrown;
        }
      }

      throw new Error("illegal catch attempt");
    },
    delegateYield: function delegateYield(iterable, resultName, nextLoc) {
      return this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      }, "next" === this.method && (this.arg = undefined), ContinueSentinel;
    }
  }, exports;
}

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) {
  try {
    var info = gen[key](arg);
    var value = info.value;
  } catch (error) {
    reject(error);
    return;
  }

  if (info.done) {
    resolve(value);
  } else {
    Promise.resolve(value).then(_next, _throw);
  }
}

function _asyncToGenerator(fn) {
  return function () {
    var self = this,
        args = arguments;
    return new Promise(function (resolve, reject) {
      var gen = fn.apply(self, args);

      function _next(value) {
        asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value);
      }

      function _throw(err) {
        asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err);
      }

      _next(undefined);
    });
  };
}



var BASE_VOUCHER = function () {
  var scroll = function scroll() {
    var element = document.querySelector(".frag-footer");
    if (!element) return;
    var elementFooter = document.querySelector(".form-footer");
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) {
          elementFooter.classList.add("sticky");
          return;
        }

        elementFooter.classList.remove("sticky");
      });
    });
    io.observe(element);
  };

  var format = function format() {
    var inputEls = document.querySelectorAll("[inf]");
    inputEls.forEach(function (inputEl) {
      inputEl.addEventListener("input", /*#__PURE__*/function () {
        var _ref = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(e) {
          var valueInput, val, inputCurrent;
          return _regeneratorRuntime().wrap(function _callee$(_context) {
            while (1) {
              switch (_context.prev = _context.next) {
                case 0:
                  valueInput = inputEl.value.replaceAll(",", "").replaceAll(".", "").replaceAll(/[a-zA-Z]/g, "");
                  val = valueInput === "" ? "" : parseFloat(valueInput);
                  inputCurrent = inputEl.nextElementSibling;
                  _context.next = 5;
                  return _roniejisa_scripts_assets_js_Helper__WEBPACK_IMPORTED_MODULE_0__["default"].number_format(val);

                case 5:
                  inputEl.value = _context.sent;
                  inputCurrent.value = val;
                  inputCurrent.dispatchEvent(new Event("input"));

                case 8:
                case "end":
                  return _context.stop();
              }
            }
          }, _callee);
        }));

        return function (_x) {
          return _ref.apply(this, arguments);
        };
      }());
    });
  };

  return {
    _: function _() {
      scroll();
      format();
    }
  };
}();

var MODALPRODUCT = function () {
  function showModal() {
    $("#modalProduct").on("shown.bs.modal", function (e) {
      var _this = $(this);

      if (e.relatedTarget.dataset.typeProduct == "sub") {
        saveDataCurrent();
      }

      var dataConfig = {
        promotion: e.relatedTarget.dataset.type,
        action: e.relatedTarget.dataset.action,
        type: e.relatedTarget.dataset.typeProduct
      };
      var shop_id = document.querySelector('[name="shop_id"]');

      if (shop_id) {
        dataConfig["shop_id"] = shop_id.value;
      }

      if (document.querySelector('[name="start_at"]')) {
        dataConfig["start_at"] = document.querySelector('[name="start_at"]').value;
      }

      if (document.querySelector('[name="expired_at"]')) {
        dataConfig["expired_at"] = document.querySelector('[name="expired_at"]').value;
      }

      $.ajax({
        url: "tpv/voucher/show-product",
        data: dataConfig
      }).done(function (res) {
        _this.find(".modal-content").html(res.html);

        M_CHECKBOX.clear();
        M_CHECKBOX.refresh();
        VALIDATE_FORM.refresh();
        applyProductForPromotion();
        paginateCategory();
        showAndHideProductSelected();
        formSearch();
      });
    });
  }

  function paginateCategory() {
    var paginate = document.querySelectorAll("[paginate-modal-product]");
    paginate.forEach(function (pagination) {
      var paginateList = pagination.getElementsByTagName("a");
      Array.from(paginateList).forEach(function (anchorEl) {
        anchorEl.onclick = function (e) {
          e.preventDefault();
          var getAttribute = new FormDataRS("filter");
          var data = getAttribute.getObjectData();
          data["page"] = anchorEl.dataset.page;
          data["item_chooses"] = localStorage.getItem(anchorEl.closest("[m-checkbox]").getAttribute("m-checkbox").toUpperCase());

          if (document.querySelector('[name="start_at"]')) {
            data["start_at"] = document.querySelector('[name="start_at"]').value;
          }

          if (document.querySelector('[name="expired_at"]')) {
            data["expired_at"] = document.querySelector('[name="expired_at"]').value;
          }

          searchProduct(data);
        };
      });
    });
  }

  function formSearch() {
    var formButton = document.querySelector('.form-search-item [type="button"]');
    if (!formButton) return;
    var timeout;

    formButton.onclick = function () {
      clearTimeout(timeout);
      timeout = setTimeout(function () {
        var data = new FormDataRS("filter", false);
        data = data.getObjectData();
        var inputChecked = document.querySelector("#product_has_promotion");
        data["item_chooses"] = localStorage.getItem(inputChecked.closest(".modal-content").getAttribute("m-checkbox").toUpperCase());
        searchProduct(data);
      }, 400);
    };
  }

  function saveDataCurrent(type) {
    var itemProductSub = document.querySelector(".item-product-sub");
    var data = [];
    var items = itemProductSub.querySelectorAll("[c-check-item]");
    if (items.length == 0) return;
    items.forEach(function (item, key) {
      var itemChildChecked = item.querySelectorAll("[c-single]");
      itemChildChecked.forEach(function (itemChild) {
        itemChild = itemChild.closest(".item-child");
        var inputs = itemChild.querySelectorAll("[name]");
        var dataItem = XHR.buildData(inputs, true);
        data.push(dataItem);
      });
    });
    return $.ajax({
      url: "sys-promotion/deals/save-product-sub",
      method: "POST",
      data: {
        data: JSON.stringify(data)
      }
    }).done(function (res) {
      if (res.code == 200) {
        return true;
      }

      return false;
    });
  }

  function applyProductForPromotion() {
    var buttonChooseProduct = document.querySelector(".choose-product-button");

    if (buttonChooseProduct) {
      buttonChooseProduct.onclick = /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var promotion, action, type, isPass;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                promotion = buttonChooseProduct.dataset.type;
                action = buttonChooseProduct.dataset.action;
                type = buttonChooseProduct.dataset.typeProduct;
                isPass = true;
                _context2.t0 = promotion;
                _context2.next = _context2.t0 === "vouchers" ? 7 : 11;
                break;

              case 7:
                _context2.next = 9;
                return applyProductForVoucher(promotion, action);

              case 9:
                isPass = _context2.sent;
                return _context2.abrupt("break", 11);

              case 11:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }));
    }
  }

  function applyProductForVoucher(_x2) {
    return _applyProductForVoucher.apply(this, arguments);
  }

  function _applyProductForVoucher() {
    _applyProductForVoucher = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4(promotion) {
      var productChoose;
      return _regeneratorRuntime().wrap(function _callee4$(_context4) {
        while (1) {
          switch (_context4.prev = _context4.next) {
            case 0:
              productChoose = document.querySelector('textarea[name="product_choose"]');

              if (productChoose !== null) {
                $.ajax({
                  url: "tpv/voucher/choose-product-for-promotion",
                  method: "POST",
                  data: {
                    item_id: JSON.parse(productChoose.value),
                    promotion: promotion
                  }
                }).done(function (res) {
                  document.querySelector(".item-product").innerHTML = res.html;
                  VOUCHER.paginationList();
                  VOUCHER.removeProductOfVoucher();
                  $("#modalProduct").modal("hide");
                  $("#modalProduct .modal-content").html("");
                });
              }

              localStorage.removeItem("CHOOSE_" + promotion.toUpperCase());

            case 3:
            case "end":
              return _context4.stop();
          }
        }
      }, _callee4);
    }));
    return _applyProductForVoucher.apply(this, arguments);
  }

  function showAndHideProductSelected() {
    var timeout;
    var inputChecked = document.querySelector("#product_has_promotion");
    if (!inputChecked) return;
    inputChecked.onchange = /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
      var data;
      return _regeneratorRuntime().wrap(function _callee3$(_context3) {
        while (1) {
          switch (_context3.prev = _context3.next) {
            case 0:
              clearTimeout(timeout);
              data = new FormDataRS("filter", false);
              data = data.getObjectData();
              data["item_chooses"] = localStorage.getItem(inputChecked.closest(".modal-content").getAttribute("m-checkbox").toUpperCase());
              timeout = setTimeout(function () {
                searchProduct(data);
              }, 500);

            case 5:
            case "end":
              return _context3.stop();
          }
        }
      }, _callee3);
    }));
  }

  function searchProduct(data) {
    $.ajax({
      url: "tpv/voucher/search-product",
      type: "POST",
      data: data
    }).done(function (res) {
      var customList = document.querySelector("#modalProduct table");
      customList.innerHTML = res.html;
      paginateCategory();
      M_CHECKBOX.refresh();
    });
  }

  return {
    _: function _() {
      showModal();
    }
  };
}();

window["AJAX_PROMOTION"] = function () {
  function _createSuccess(json) {
    if (json.code == 200) {
      $.simplyToast(json.message, "success");

      if (json.redirect_url) {
        return window.location.href = json.redirect_url;
      }
    } else {
      $.simplyToast(json.message, "danger");
    }
  }

  function _alert(json) {
    if (json.code == 200 && json.message) {
      $.simplyToast(json.message, "success");
    } else if (json.code == 100 && json.message) {
      $.simplyToast(json.message, "danger");
    }
  }

  return {
    createSuccess: function createSuccess(json) {
      _createSuccess(json);
    },
    alert: function alert(json) {
      _alert(json);
    }
  };
}();

var VOUCHER = function () {
  var typeDiscountOld;
  var typeSaleOld;
  var typeLimitOld;
  var typeUsedOld;
  var numberSatifyOld;
  var typeSaleCurrent;
  var typeDiscountCurrent;
  var VOUCHER_FOR_SHOP = 1;
  var VOUCHER_FOR_PRODUCT = 2;
  var VOUCHER_DISCOUNT_BY_MONEY = 1;
  var VOUCHER_DISCOUNT_BY_PERCENT = 2;
  var DICOUNT_PROMOTION = 1;
  var DICOUNT_REFUND_COIN = 2;
  var REFUND_LIMIT = 1;
  var REFUND_NO_LIMIT = 2;
  var TYPE_USED_NULL = 0;
  var TYPE_USED_MONEY = 1;
  var TYPE_USED_FOR_BUY_ORDER = 1;
  var voucherStorage = new Storage();

  function changeInputMax() {
    var refundLimitGroup = document.getElementById("refund-limit-group");
    if (!refundLimitGroup) return;
    var inputs = refundLimitGroup.querySelectorAll("input");
    var divChooseFooter = refundLimitGroup.querySelector(".choose-coin__footer");
    inputs.forEach(function (input) {
      if (input.name == "max_discount") {
        input.addEventListener("input", changeTotalCoin, false);
      } else {
        var ipMaxDiscount = divChooseFooter.querySelector("input");
        input.onchange = /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee5() {
          return _regeneratorRuntime().wrap(function _callee5$(_context5) {
            while (1) {
              switch (_context5.prev = _context5.next) {
                case 0:
                  setMaxDiscount(refundLimitGroup);
                  _context5.next = 3;
                  return ipMaxDiscount.addEventListener("input", changeTotalCoin);

                case 3:
                  VALIDATE_FORM.refresh();

                case 4:
                case "end":
                  return _context5.stop();
              }
            }
          }, _callee5);
        }));
      } // Lấy loại giảm giá


      var inputRadios = Array.from(inputs).filter(function (input) {
        return input.type === "radio";
      });
      inputRadios.forEach(function (input, indexCurrent) {
        input.addEventListener("change", function () {
          var inputMaxFake = divChooseFooter.querySelector("input");
          var inputMax = divChooseFooter.querySelector("input[name='max_discount']");
          voucherStorage.set("type_limit-".concat(typeSaleCurrent, "-").concat(typeDiscountCurrent), input.value);
          typeLimitOld = input.value;
          voucherStorage.set("max_discount-".concat(typeSaleOld, "-").concat(typeDiscountOld), inputMax.value);
          var inputMaxIsLimit = input.checked && input.value == REFUND_NO_LIMIT;
          inputMaxIsLimit ? divChooseFooter.setAttribute("style", "display:none") : divChooseFooter.removeAttribute("style");
          inputMax.setAttribute("disabled", inputMaxIsLimit);
          inputMaxFake.setAttribute("disabled", inputMaxIsLimit);
          VALIDATE_FORM.refresh();
          setMaxDiscount(refundLimitGroup);
          getDataMaxDiscount(inputMax);
        });
      });
    });
  }

  function onInputShowVoucherCode() {
    var inputVoucher = document.getElementById("voucher_code");

    if (inputVoucher) {
      inputVoucher.addEventListener("input", /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee6() {
        var valueInput;
        return _regeneratorRuntime().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                _context6.next = 2;
                return _roniejisa_scripts_assets_js_Helper__WEBPACK_IMPORTED_MODULE_0__["default"].nonAccentVietnamese(inputVoucher.value);

              case 2:
                valueInput = _context6.sent;
                valueInput = valueInput.toUpperCase();
                inputVoucher.value = valueInput;
                document.querySelector(".input_code").innerHTML = valueInput;
                document.querySelector(".voucher-code__suffix").innerHTML = valueInput.length + " ký tự";

              case 7:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      })));
    }
  }

  function changeTypeVoucher() {
    var typeVoucher = document.querySelectorAll(".voucher-type__item input");
    typeVoucher.forEach(function (inputType) {
      inputType.onchange = function () {
        var applyProduct = document.querySelector(".apply-product");
        var allCategory = document.querySelector(".voucher-category-all");
        var applyCategory = document.querySelector(".apply-category");

        if (inputType.checked && inputType.value == VOUCHER_FOR_SHOP) {
          applyCategory.classList.add("d-none");
          applyCategory.innerHTML = "";
          allCategory.classList.remove("d-none");
          applyProduct.querySelector(".voucher-for").classList.remove("d-none");
          applyProduct.querySelector("button").classList.add("d-none");
          applyProduct.querySelector(".item-product").classList.add("d-none");
        } else if (inputType.value == VOUCHER_FOR_PRODUCT) {
          applyProduct.querySelector(".voucher-for").classList.add("d-none");
          applyProduct.querySelector("button").classList.remove("d-none");
          applyProduct.querySelector(".item-product").classList.remove("d-none");
          applyCategory.classList.remove("d-none");
          allCategory.classList.add("d-none");
          var data = localStorage.getItem(applyCategory.getAttribute("m-checkbox").toUpperCase());
          $.ajax({
            url: "tpv/voucher/show-list-category",
            method: "GET",
            data: {
              promotion: "vouchers",
              data: data
            }
          }).done(function (res) {
            applyCategory.innerHTML = res.html;
            M_CHECKBOX.refresh();
            paginateCategoryList();
            searchCategory();
            checkedShowCategory();
          });
        }
      };
    });
  }

  var paginateCategoryList = function paginateCategoryList() {
    var paginationEl = document.querySelectorAll("[pagination-category-list] a");
    paginationEl.forEach(function (el) {
      el.onclick = function (e) {
        e.preventDefault();
        var promotion = el.dataset.promotion;
        var page = el.dataset.page;
        var data = localStorage.getItem(el.closest("[m-checkbox]").getAttribute("m-checkbox").toUpperCase());
        var formData = {
          page: page,
          promotion: promotion,
          data: data,
          isShow: document.querySelector("#show-category-selected").checked ? 1 : 0
        };
        searchCategoryAjax(formData);
      };
    });
  };

  var searchCategoryAjax = function searchCategoryAjax(data) {
    $.ajax({
      url: "tpv/voucher/search-category",
      method: "POST",
      data: data
    }).then(function (res) {
      document.querySelector(".list-table").innerHTML = res.html;
      paginateCategoryList();
      M_CHECKBOX.refresh();
    });
  };

  var searchCategory = function searchCategory() {
    var buttonSubmit = document.querySelector(".search-voucher-category");
    var timeout;
    if (!buttonSubmit) return;

    buttonSubmit.onclick = function () {
      clearTimeout(timeout);
      var q = buttonSubmit.previousElementSibling;
      var formData = {
        promotion: "vouchers",
        data: localStorage.getItem(buttonSubmit.closest("[m-checkbox]").getAttribute("m-checkbox").toUpperCase()),
        isShow: document.querySelector("#show-category-selected").checked ? 1 : 0,
        q: q.value
      };
      timeout = setTimeout(function () {
        searchCategoryAjax(formData);
      }, 300);
    };
  };

  function getLimitType(refundLimitGroup) {
    var inputOfMaxDiscountEl = refundLimitGroup.querySelectorAll("input");
    var limitCurrent = Array.from(inputOfMaxDiscountEl).find(function (input) {
      return input.checked;
    }) ? Array.from(inputOfMaxDiscountEl).find(function (input) {
      return input.checked;
    }).value : 1;
    return {
      inputOfMaxDiscountEl: inputOfMaxDiscountEl,
      limitCurrent: limitCurrent
    };
  }

  function changeTypeDiscount() {
    var refundLimitGroup = document.getElementById("refund-limit-group");
    if (!refundLimitGroup) return;

    var _getLimitType = getLimitType(refundLimitGroup),
        limitCurrent = _getLimitType.limitCurrent;

    typeLimitOld = limitCurrent;
    var inputMaxDiscount = refundLimitGroup.querySelector('input[name="max_discount"]');
    var typeDiscount = document.getElementById("type-discount");
    if (!typeDiscount) return;

    typeDiscount.onchange = function (e) {
      var divType = this.closest(".voucher-discount");
      var inputDiscount = divType.querySelector('input[name="discount"]');
      voucherStorage.set("discount-".concat(typeSaleOld, "-").concat(typeDiscountOld), inputDiscount.value !== "" ? parseFloat(inputDiscount.value) : "");
      voucherStorage.set("max_discount-".concat(typeSaleOld, "-").concat(typeDiscountCurrent), inputMaxDiscount.value !== "" ? parseFloat(inputMaxDiscount.value) : "");
      voucherStorage.set("type_limit-".concat(typeSaleOld, "-").concat(typeDiscountOld), typeLimitOld);
      typeDiscountCurrent = typeDiscount.value;
      typeDiscountOld = typeDiscountCurrent;
      voucherStorage.set("type_discount-".concat(typeSaleOld), typeDiscountCurrent);
      setMaxDiscount(refundLimitGroup, typeSaleOld == DICOUNT_PROMOTION ? true : false);
      setInputDiscount(inputDiscount, typeSaleOld == DICOUNT_PROMOTION ? true : false);
      getDataDiscount(inputDiscount);
      VALIDATE_FORM.refresh();
      changeTypeDiscount();
    };
  }

  function changeTypeSale() {
    var typeSales = document.querySelectorAll(".voucher-saleBy__item input");
    typeSales.forEach(function (typeSale) {
      var refundLimitGroup = document.getElementById("refund-limit-group");
      if (!refundLimitGroup) return;
      var typeDiscount = document.getElementById("type-discount");
      var inputDiscount = document.querySelector('input[name="discount"]');
      var inputMaxDiscount = refundLimitGroup.querySelector('input[name="max_discount"]');

      var _getLimitType2 = getLimitType(refundLimitGroup),
          limitCurrent = _getLimitType2.limitCurrent;

      typeLimitOld = limitCurrent; // lưu lại giá trị của loại lúc bắt đầu

      typeDiscountOld = typeDiscount.value; // Lưu dữ liệu cũ của typeVoucher

      buildOldData(typeSale, inputDiscount, inputMaxDiscount); //Thay đổi loại mã giảm giá

      typeSale.onchange = function () {
        typeSaleCurrent = typeSale.value; // Lưu lại giá trị trước khi thay đổi loại mã giảm giá

        saveDataTypeChange(inputDiscount, inputMaxDiscount); // Lấy lại loại giảm giá từ trong storage

        typeDiscountOld = voucherStorage.has("type_discount-".concat(typeSale.value)) ? voucherStorage.get("type_discount-".concat(typeSale.value)) : document.getElementById("type-discount").value;
        var isPromotion = true;

        if (this.value == DICOUNT_PROMOTION) {
          isPromotion = true;
        } else if (this.value == DICOUNT_REFUND_COIN) {
          isPromotion = false;
        }

        setTypeDiscount(typeDiscount, isPromotion);
        typeDiscountCurrent = document.getElementById("type-discount").value;
        typeLimitOld = voucherStorage.has("type_limit-".concat(typeSale.value, "-").concat(typeDiscountCurrent)) ? voucherStorage.get("type_limit-".concat(typeSale.value, "-").concat(typeDiscountCurrent)) : 1;
        setMaxDiscount(refundLimitGroup, isPromotion);
        setInputDiscount(inputDiscount, isPromotion);
        typeSaleOld = typeSale.value; // Xử lý data inputDiscount

        getDataDiscount(inputDiscount); // Xử lý data inputMaxDiscount

        getDataMaxDiscount(inputMaxDiscount);
        VALIDATE_FORM.refresh();
        changeTypeDiscount();
      };
    });
  }

  function buildOldData(typeSale, inputDiscount, ipMaxDiscount) {
    typeDiscountCurrent == VOUCHER_DISCOUNT_BY_PERCENT ? voucherStorage.set("type_limit-".concat(typeSale.value, "-").concat(VOUCHER_DISCOUNT_BY_PERCENT), typeLimitOld) : voucherStorage.set("type_limit-".concat(typeSale.value, "-").concat(VOUCHER_DISCOUNT_BY_PERCENT), typeLimitOld);
    if (!typeSale.checked) return;
    typeSaleOld = typeSale.value;
    typeSaleCurrent = typeSaleOld;
    voucherStorage.set("discount-".concat(typeSaleOld, "-").concat(typeDiscountOld), inputDiscount.value !== "" ? parseFloat(inputDiscount.value) : "");
    voucherStorage.set("max_discount-".concat(typeSaleOld, "-").concat(typeDiscountOld), ipMaxDiscount.value !== "" ? parseFloat(ipMaxDiscount.value) : "");
    voucherStorage.set("type_discount-".concat(typeSaleOld), typeDiscountCurrent);
  }

  function getDataMaxDiscount(ipMaxDiscount) {
    var fakeInputMaxDiscount = ipMaxDiscount.previousElementSibling;
    var totalCoinAndMoney = ipMaxDiscount.closest(".choose-coin__footer").querySelector(".total-coin");
    fakeInputMaxDiscount.value = "";
    ipMaxDiscount.value = "";
    totalCoinAndMoney.innerHTML = "";
    if (!voucherStorage.has("max_discount-".concat(typeSaleOld, "-").concat(typeDiscountOld))) return;
    var valueMaxDiscount = voucherStorage.get("max_discount-".concat(typeSaleOld, "-").concat(typeDiscountOld));
    var money = _roniejisa_scripts_assets_js_Helper__WEBPACK_IMPORTED_MODULE_0__["default"].number_format(valueMaxDiscount);
    fakeInputMaxDiscount.value = valueMaxDiscount != undefined ? money : "";
    ipMaxDiscount.value = valueMaxDiscount != undefined ? valueMaxDiscount : "";
    totalCoinAndMoney.innerHTML = money;
  }

  function getDataDiscount(inputDiscount) {
    var valueOld = voucherStorage.get("discount-".concat(typeSaleOld, "-").concat(typeDiscountOld));
    inputDiscount.previousElementSibling.value = valueOld != undefined ? _roniejisa_scripts_assets_js_Helper__WEBPACK_IMPORTED_MODULE_0__["default"].number_format(valueOld) : "";
    inputDiscount.value = valueOld != undefined ? valueOld : "";
  }

  function setMaxDiscount(refundLimitGroup) {
    var isPromotion = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
    var divChooseFooter = refundLimitGroup.querySelector(".choose-coin__footer");
    var prefixMoneyMaxValue = divChooseFooter.querySelector(".prefix-money");
    var divInputLimit = refundLimitGroup.querySelector(".input-refund-limit");
    var ipMaxDiscount = divInputLimit.querySelector('[name="max_discount"]');
    var prefixMaxDiscount = divInputLimit.querySelector(".limit-prefix");

    var _getLimitType3 = getLimitType(refundLimitGroup),
        inputOfMaxDiscountEl = _getLimitType3.inputOfMaxDiscountEl;

    ipMaxDiscount.placeholder = typeDiscountCurrent == VOUCHER_DISCOUNT_BY_MONEY ? "Nhập số tiền tối đa" : "Nhập số COIN tối đa";
    prefixMaxDiscount.innerHTML = isPromotion ? "VND" : "COIN";
    prefixMoneyMaxValue.innerHTML = isPromotion ? "VND" : "COIN";
    var isLimit = voucherStorage.get("type_limit-".concat(typeSaleCurrent, "-").concat(typeDiscountCurrent)); // Kiểm tra không giới hạn hoặc loại voucher bằng tiền thì ẩn ô nhập giới hạn

    typeDiscountCurrent == VOUCHER_DISCOUNT_BY_MONEY || isLimit == REFUND_NO_LIMIT ? divChooseFooter.style.display = "none" : divChooseFooter.removeAttribute("style"); // Kiểm tra nếu loại voucher bằng tiền thì ẩn phần chọn giới hạn

    typeDiscountCurrent == VOUCHER_DISCOUNT_BY_MONEY ? refundLimitGroup.style.display = "none" : refundLimitGroup.removeAttribute("style"); // Kiểm tra nếu loại voucher là phần trăm thì mở chọn giới hạn

    Array.from(inputOfMaxDiscountEl).filter(function (input) {
      return input.type == "radio";
    }).forEach(function (input) {
      input.disabled = typeDiscountCurrent != VOUCHER_DISCOUNT_BY_PERCENT;
      input.checked = input.value == isLimit;
    });
    Array.from(inputOfMaxDiscountEl).filter(function (input) {
      return input.type != "radio";
    }).forEach(function (input) {
      input.disabled = typeDiscountCurrent != VOUCHER_DISCOUNT_BY_PERCENT && isLimit == REFUND_NO_LIMIT;
    });
  }

  function setInputDiscount(inputDiscount) {
    var isPromotion = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
    var prefixIpDiscount = inputDiscount.parentElement.querySelector(".voucher-discount__prefix");
    var inputDiscountFake = inputDiscount.previousElementSibling;
    isPromotion ? prefixIpDiscount.innerHTML = typeDiscountOld == VOUCHER_DISCOUNT_BY_MONEY ? "VND" : "% Giảm" : prefixIpDiscount.innerHTML = "% Hoàn coin";
    inputDiscountFake.placeholder = typeDiscountOld == VOUCHER_DISCOUNT_BY_MONEY ? "Số tiền giảm" : "Nhập % giảm giá lớn hơn 1";
    inputDiscountFake.setAttribute("rules", typeDiscountOld == VOUCHER_DISCOUNT_BY_MONEY ? "required" : "required||min:5||max:90");
    return true;
  }

  function setTypeDiscount(typeDiscount) {
    var isPromotion = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
    typeDiscount.innerHTML = isPromotion ? " <option value=\"".concat(VOUCHER_DISCOUNT_BY_MONEY, "\"\n                    ").concat(typeDiscountOld == VOUCHER_DISCOUNT_BY_MONEY ? "selected" : "", ">\n                        Theo s\u1ED1 ti\u1EC1n\n                </option>\n                <option value=\"").concat(VOUCHER_DISCOUNT_BY_PERCENT, "\"\n                    ").concat(typeDiscountOld == VOUCHER_DISCOUNT_BY_PERCENT ? "selected" : "", ">\n                        Theo ph\u1EA7n tr\u0103m\n                </option>") : "<option value=\"".concat(VOUCHER_DISCOUNT_BY_PERCENT, "\">Theo ph\u1EA7n tr\u0103m</option>");
  }

  function saveDataTypeChange(inputDiscount, inputMaxDiscount) {
    voucherStorage.set("discount-".concat(typeSaleOld, "-").concat(typeDiscountOld), inputDiscount.value !== "" ? parseFloat(inputDiscount.value) : "");
    voucherStorage.set("max_discount-".concat(typeSaleOld, "-").concat(typeDiscountOld), inputMaxDiscount.value !== "" ? parseFloat(inputMaxDiscount.value) : "");
    voucherStorage.set("type_discount-".concat(typeSaleOld), typeDiscountOld);
  }

  function changeTotalCoin() {
    document.querySelector(".total-coin").innerHTML = _roniejisa_scripts_assets_js_Helper__WEBPACK_IMPORTED_MODULE_0__["default"].number_format(this.value.replaceAll(".", "").replaceAll(",", ""));
  }

  function changeTypeUsed() {
    var inputRadios = document.querySelectorAll("[name='type_used']");
    var inputSatisfy = document.querySelector("[name='number_satisfy']");
    if (!inputSatisfy) return;
    typeUsedOld = Array.from(inputRadios).find(function (input) {
      return input.checked;
    }).value;
    setDataOldSatisfy(typeUsedOld, inputSatisfy.value);
    inputRadios.forEach(function (item) {
      item.onclick = function () {
        setDataOldSatisfy(typeUsedOld, inputSatisfy.value);
        typeUsedOld = item.value;
        inputSatisfy.disabled = item.value == TYPE_USED_NULL;
        inputSatisfy.value = item.value == TYPE_USED_NULL ? "" : getDataOldSatisfy(typeUsedOld);
      };
    });
  }

  function getDataOldSatisfy(valueInput) {
    var value = voucherStorage.get("type_used-".concat(valueInput));
    return !value ? "" : value;
  }

  function setDataOldSatisfy(typeUsedOld, valueNumberSatisfy) {
    voucherStorage.set("type_used-".concat(typeUsedOld), valueNumberSatisfy);
  }

  function sendVoucher() {
    var button = document.querySelector(".send-voucher-for-user.all");
    if (!button) return;
    var timeout;

    button.onclick = function (e) {
      e.preventDefault();
      clearTimeout(timeout);
      timeout = setTimeout(function () {
        XHR.send({
          url: "tpv/voucher/send",
          method: "POST",
          data: {
            voucher_id: button.dataset.id
          }
        }).then(function (res) {
          AJAX_PROMOTION.createSuccess(res);
        });
      }, 400);
    };
  }

  function sendVoucherSelect() {
    var button = document.querySelector(".send-voucher-for-user.select");
    if (!button) return;

    if (localStorage.getItem("SET_NOTIFICAITON_VOUCHER_".concat(button.dataset.id))) {
      localStorage.removeItem("SET_NOTIFICAITON_VOUCHER_".concat(button.dataset.id));
    }

    var timeout;

    button.onclick = function (e) {
      e.preventDefault();
      clearTimeout(timeout);
      timeout = setTimeout(function () {
        XHR.send({
          url: "tpv/voucher/send",
          method: "POST",
          data: {
            voucher_id: button.dataset.id,
            id: JSON.parse(localStorage.getItem("SET_NOTIFICAITON_VOUCHER_".concat(button.dataset.id)))
          }
        }).then(function (res) {
          AJAX_PROMOTION.createSuccess(res);
        });
      }, 400);
    };
  }

  var _paginationList = function paginationList() {
    var paginationEl = document.querySelectorAll("[pagination-voucher-list] a");
    paginationEl.forEach(function (el) {
      el.onclick = function (e) {
        e.preventDefault();
        var promotion = el.dataset.promotion;
        var page = el.dataset.page;
        $.ajax({
          url: "tpv/voucher/load-product",
          method: "POST",
          data: {
            page: page,
            promotion: promotion
          }
        }).then(function (res) {
          el.closest(".list-product").innerHTML = res.html;

          _paginationList();

          _removeProductOfVoucher();
        });
      };
    });
  };

  function _removeProductOfVoucher() {
    var buttonRemove = document.querySelectorAll(".item-product .action button");
    buttonRemove.forEach(function (button) {
      button.onclick = function () {
        bootbox.confirm("Bạn có muốn xóa sản phẩm này!", function (result) {
          if (result) {
            $.ajax({
              url: "tpv/voucher/remove-product",
              method: "POST",
              data: {
                id: button.closest("tr").dataset.id
              }
            }).done(function (res) {
              if (res.count == 0) {
                document.querySelector(".item-product").innerHTML = "<button type=\"button\" class=\"btn bg-green-400 text-white\" data-toggle=\"modal\" data-target=\"#modalProduct\" data-type=\"vouchers\">\n                        Th\xEAm s\u1EA3n ph\u1EA9m\n                    </button>";
              } else {
                button.closest(".list-product").innerHTML = res.html;
                document.querySelector(".count-product-chooses").innerHTML = res.count;

                _paginationList();

                _removeProductOfVoucher();
              }
            });
          }
        });
      };
    });
  }

  var checkedShowCategory = function checkedShowCategory() {
    var inputChecked = document.querySelector("#show-category-selected");
    if (!inputChecked) return;
    var timeout;

    inputChecked.onchange = function () {
      clearTimeout(timeout);
      timeout = setTimeout(function () {
        var data = {
          promotion: "vouchers",
          data: document.querySelector('[name="list_category"]').value,
          isShow: inputChecked.checked ? 1 : 0,
          q: document.querySelector(".category-filter input").value
        };
        searchCategoryAjax(data);
      }, timeout);
      paginateCategoryList();
    };
  };

  return {
    _: function _() {
      onInputShowVoucherCode();
      changeTypeVoucher();
      changeTypeDiscount();
      changeTypeSale();
      sendVoucher();
      changeInputMax();
      sendVoucherSelect();
      changeTypeUsed();

      _paginationList();

      checkedShowCategory();

      _removeProductOfVoucher();

      searchCategory();
      localStorage.setItem("CATEGORY_CHOOSE_VOUCHER", "");

      if (typeof M_CHECKBOX !== "undefined") {
        M_CHECKBOX.refresh();
      }

      paginateCategoryList();
    },
    paginationList: function paginationList() {
      _paginationList();
    },
    removeProductOfVoucher: function removeProductOfVoucher() {
      _removeProductOfVoucher();
    }
  };
}();

window.addEventListener("DOMContentLoaded", function () {
  VOUCHER._();

  MODALPRODUCT._();

  BASE_VOUCHER._();
});

/***/ }),

/***/ "./resources/css/app.css":
/*!*******************************!*\
  !*** ./resources/css/app.css ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./packages/tech5s/flashsale/resources/css/base.css":
/*!**********************************************************!*\
  !*** ./packages/tech5s/flashsale/resources/css/base.css ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./packages/tech5s/flashsale/resources/css/style.css":
/*!***********************************************************!*\
  !*** ./packages/tech5s/flashsale/resources/css/style.css ***!
  \***********************************************************/
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
/******/ 			"/assets/promotion/flashsale/js/flashsale": 0,
/******/ 			"admin/promotion/css/app": 0,
/******/ 			"assets/promotion/flashsale/css/style": 0,
/******/ 			"assets/promotion/flashsale/css/base": 0,
/******/ 			"css/app": 0
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
/******/ 	__webpack_require__.O(undefined, ["admin/promotion/css/app","assets/promotion/flashsale/css/style","assets/promotion/flashsale/css/base","css/app"], () => (__webpack_require__("./packages/tech5s/flashsale/resources/js/flashsale.js")))
/******/ 	__webpack_require__.O(undefined, ["admin/promotion/css/app","assets/promotion/flashsale/css/style","assets/promotion/flashsale/css/base","css/app"], () => (__webpack_require__("./packages/tech5s/flashsale/resources/css/base.css")))
/******/ 	__webpack_require__.O(undefined, ["admin/promotion/css/app","assets/promotion/flashsale/css/style","assets/promotion/flashsale/css/base","css/app"], () => (__webpack_require__("./packages/tech5s/flashsale/resources/css/style.css")))
/******/ 	__webpack_require__.O(undefined, ["admin/promotion/css/app","assets/promotion/flashsale/css/style","assets/promotion/flashsale/css/base","css/app"], () => (__webpack_require__("./packages/tech5s/promotion/resources/css/app.css")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["admin/promotion/css/app","assets/promotion/flashsale/css/style","assets/promotion/flashsale/css/base","css/app"], () => (__webpack_require__("./resources/css/app.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;