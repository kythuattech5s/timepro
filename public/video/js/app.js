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
/************************************************************************/
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
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!***********************************************************!*\
  !*** ./packages/tech5s/video-chapter/resources/js/app.js ***!
  \***********************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _roniejisa_scripts_assets_js_Helper_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../roniejisa/scripts/assets/js/Helper.js */ "./packages/roniejisa/scripts/assets/js/Helper.js");
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



(function () {
  var load = function load() {
    var video = document.querySelector("video");
    if (!video) return;
    video.onplay = handleEventVideo;
    video.onpause = handleEventVideo;
  };

  var handleEventVideo = function handleEventVideo(e) {
    var video = e.target;
    var currentTime = video.currentTime;
    XHR.send({
      url: "danh-dau-da-hoc-xong",
      method: "POST",
      data: {
        course_video_id: video.dataset.id,
        duration: currentTime
      }
    }).then(function (res) {
      var listVideo = document.querySelectorAll("[data-link]");
      listVideo.forEach(function (item) {
        if (video.dataset.id == item.dataset.id) {
          item.classList.add("playing");
        } else if (item.classList.contains("playing")) {
          item.classList.remove("playing");
        }
      });
    });
  };

  var changeVideo = function changeVideo() {
    var timeout;
    var video = document.querySelector("video");
    if (!video) return;
    var listVideo = document.querySelectorAll("[data-link]");
    listVideo.forEach(function (item) {
      item.onclick = function () {
        if (video.dataset.id == item.dataset.id) return;
        clearTimeout(timeout);
        timeout = setTimeout( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
          var res, parent, html;
          return _regeneratorRuntime().wrap(function _callee$(_context) {
            while (1) {
              switch (_context.prev = _context.next) {
                case 0:
                  _context.next = 2;
                  return XHR.send({
                    url: "/get-video-src?course_video_id=".concat(item.dataset.id),
                    method: "get"
                  });

                case 2:
                  res = _context.sent;

                  if (typeof VIDEO_ID != "undefined") {
                    VIDEO_ID = res.secretId;
                  }

                  parent = video.closest(".video-lesson");
                  html = "<video-js id=\"my_video_1\" class=\"video-js vjs-default-skin vjs-16-9\" controls preload=\"none\" data-id=\"".concat(item.dataset.id, "\" width=\"640\" height=\"268\" poster=\"").concat(res.poster, "\">\n                            <source src=\"").concat(res.src, "\" type=\"application/x-mpegURL\">\n                        </video-js>");
                  video.parentElement.remove();
                  _context.next = 9;
                  return videojs("my_video_1").dispose();

                case 9:
                  _context.next = 11;
                  return html;

                case 11:
                  parent.innerHTML = _context.sent;
                  Tech5sVideo.init();
                  load();
                  checkTime();
                  changeVideo();
                  toTime();
                  catchEventVideo();
                  showRatingForm();
                  backToCourse();
                  showListNote(item.dataset.id, item, video);

                case 21:
                case "end":
                  return _context.stop();
              }
            }
          }, _callee);
        })), 400);
      };
    });
  };

  var showListNote = function showListNote(id, item, video) {
    XHR.send({
      url: "lay-danh-sach-ghi-chu",
      method: "POST",
      data: {
        course_video_id: id
      }
    }).then(function (res) {
      // video.querySelector("source").src = item.dataset.link;
      video.dataset.id = id;
      document.querySelector("[list-note]").innerHTML = res.html;
      toTime();
      video.load();
      video.play();
    });
  };

  var catchEventVideo = function catchEventVideo() {
    var video = document.querySelector("video");
    if (!video) return;

    video.onended = function (e) {
      var listVideo = document.querySelectorAll("[data-link]");
      XHR.send({
        url: "danh-dau-da-hoc-xong",
        method: "POST",
        data: {
          course_video_id: video.dataset.id,
          is_done: 1,
          duration: video.currentTime
        }
      }).then( /*#__PURE__*/function () {
        var _ref2 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2(res) {
          var index, buttonRatingHTML;
          return _regeneratorRuntime().wrap(function _callee2$(_context2) {
            while (1) {
              switch (_context2.prev = _context2.next) {
                case 0:
                  listVideo.forEach(function (item, i) {
                    if (video.dataset.id == item.dataset.id) {
                      index = i;
                    }
                  });
                  listVideo[index].classList.add("active");

                  if (listVideo[index].classList.contains("playing")) {
                    listVideo[index].classList.remove("playing");
                  }

                  if (index >= listVideo.length - 1) {
                    video.pause();
                    buttonRatingHTML = "<button rating-course class=\"btn btn-red-gradien mx-auto flex w-fit items-center justify-center rounded bg-gradient-to-r from-[#F44336] to-[#C62828] py-2 px-4 font-semibold uppercase text-white shadow-[0_6px_20px_rgba(178,30,37,.4)]\">\u0110\xE1nh gi\xE1 kh\xF3a h\u1ECDc</button>";

                    if (!listVideo[listVideo.length - 1].closest(".list-lesson__item").parentElement.querySelector("button[rating-course]")) {
                      listVideo[listVideo.length - 1].closest(".list-lesson__item").insertAdjacentHTML("beforeend", buttonRatingHTML);
                      showRatingForm();
                      backToCourse();
                    }
                  } else {
                    video.querySelector("source").src = listVideo[index + 1].dataset.link;
                    video.dataset.id = listVideo[index + 1].dataset.id;
                    showListNote(listVideo[index + 1].dataset.id, listVideo[index + 1], video);
                    toTime();
                  }

                case 4:
                case "end":
                  return _context2.stop();
              }
            }
          }, _callee2);
        }));

        return function (_x) {
          return _ref2.apply(this, arguments);
        };
      }());
    };
  };

  var showRatingForm = function showRatingForm() {
    var buttonRating = document.querySelector("[rating-course]");
    if (!buttonRating) return;

    buttonRating.onclick = function () {
      var elTop = buttonRating.closest("[course-el]");
      var elParent = elTop.parentElement;
      elTop.classList.add("hidden");
      elParent.querySelector("[rating-course-el]").classList.remove("hidden");
    };
  };

  var backToCourse = function backToCourse() {
    var backCourse = document.querySelector("[back-to-course]");
    if (!backCourse) return;

    backCourse.onclick = function () {
      var elTop = backCourse.closest("[rating-course-el]");
      var elParent = elTop.parentElement;
      elTop.classList.add("hidden");
      elParent.querySelector("[course-el]").classList.remove("hidden");
    };
  };

  var checkTime = function checkTime() {
    var video = document.querySelector("video");
    var note = document.querySelector("[name='note']");
    if (!video || !note) return;

    note.onkeydown = function (e) {
      if (e.which == 13) {
        e.preventDefault();
        XHR.send({
          url: "them-ghi-chu",
          method: "POST",
          data: {
            course_video_id: video.dataset.id,
            time: video.currentTime,
            content: note.value
          }
        }).then(function (res) {
          note.value = "";
          XHR.send({
            url: "lay-danh-sach-ghi-chu",
            method: "POST",
            data: {
              course_video_id: video.dataset.id
            }
          }).then(function (res) {
            document.querySelector("[list-note]").innerHTML = res.html;
            toTime();
          });
        });
      }
    };
  };

  var toTime = function toTime() {
    var video = document.querySelector("video");
    var listNote = document.querySelectorAll("[list-note] a");
    listNote.forEach(function (item) {
      item.onclick = function () {
        video.currentTime = item.dataset.time;
        video.play();
      };
    });
  };

  return {
    init: function () {
      load();
      checkTime();
      changeVideo();
      toTime();
      catchEventVideo();
      showRatingForm();
      backToCourse();
    }()
  };
})();
})();

/******/ })()
;