/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/@babel/runtime/regenerator/index.js":
/*!**********************************************************!*\
  !*** ./node_modules/@babel/runtime/regenerator/index.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! regenerator-runtime */ "./node_modules/regenerator-runtime/runtime.js");


/***/ }),

/***/ "./node_modules/regenerator-runtime/runtime.js":
/*!*****************************************************!*\
  !*** ./node_modules/regenerator-runtime/runtime.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/**
 * Copyright (c) 2014-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

var runtime = (function (exports) {
  "use strict";

  var Op = Object.prototype;
  var hasOwn = Op.hasOwnProperty;
  var undefined; // More compressible than void 0.
  var $Symbol = typeof Symbol === "function" ? Symbol : {};
  var iteratorSymbol = $Symbol.iterator || "@@iterator";
  var asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator";
  var toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  function wrap(innerFn, outerFn, self, tryLocsList) {
    // If outerFn provided and outerFn.prototype is a Generator, then outerFn.prototype instanceof Generator.
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator;
    var generator = Object.create(protoGenerator.prototype);
    var context = new Context(tryLocsList || []);

    // The ._invoke method unifies the implementations of the .next,
    // .throw, and .return methods.
    generator._invoke = makeInvokeMethod(innerFn, self, context);

    return generator;
  }
  exports.wrap = wrap;

  // Try/catch helper to minimize deoptimizations. Returns a completion
  // record like context.tryEntries[i].completion. This interface could
  // have been (and was previously) designed to take a closure to be
  // invoked without arguments, but in all the cases we care about we
  // already have an existing method we want to call, so there's no need
  // to create a new function object. We can even get away with assuming
  // the method takes exactly one argument, since that happens to be true
  // in every case, so we don't have to touch the arguments object. The
  // only additional allocation required is the completion record, which
  // has a stable shape and so hopefully should be cheap to allocate.
  function tryCatch(fn, obj, arg) {
    try {
      return { type: "normal", arg: fn.call(obj, arg) };
    } catch (err) {
      return { type: "throw", arg: err };
    }
  }

  var GenStateSuspendedStart = "suspendedStart";
  var GenStateSuspendedYield = "suspendedYield";
  var GenStateExecuting = "executing";
  var GenStateCompleted = "completed";

  // Returning this object from the innerFn has the same effect as
  // breaking out of the dispatch switch statement.
  var ContinueSentinel = {};

  // Dummy constructor functions that we use as the .constructor and
  // .constructor.prototype properties for functions that return Generator
  // objects. For full spec compliance, you may wish to configure your
  // minifier not to mangle the names of these two functions.
  function Generator() {}
  function GeneratorFunction() {}
  function GeneratorFunctionPrototype() {}

  // This is a polyfill for %IteratorPrototype% for environments that
  // don't natively support it.
  var IteratorPrototype = {};
  IteratorPrototype[iteratorSymbol] = function () {
    return this;
  };

  var getProto = Object.getPrototypeOf;
  var NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  if (NativeIteratorPrototype &&
      NativeIteratorPrototype !== Op &&
      hasOwn.call(NativeIteratorPrototype, iteratorSymbol)) {
    // This environment has a native %IteratorPrototype%; use it instead
    // of the polyfill.
    IteratorPrototype = NativeIteratorPrototype;
  }

  var Gp = GeneratorFunctionPrototype.prototype =
    Generator.prototype = Object.create(IteratorPrototype);
  GeneratorFunction.prototype = Gp.constructor = GeneratorFunctionPrototype;
  GeneratorFunctionPrototype.constructor = GeneratorFunction;
  GeneratorFunctionPrototype[toStringTagSymbol] =
    GeneratorFunction.displayName = "GeneratorFunction";

  // Helper for defining the .next, .throw, and .return methods of the
  // Iterator interface in terms of a single ._invoke method.
  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function(method) {
      prototype[method] = function(arg) {
        return this._invoke(method, arg);
      };
    });
  }

  exports.isGeneratorFunction = function(genFun) {
    var ctor = typeof genFun === "function" && genFun.constructor;
    return ctor
      ? ctor === GeneratorFunction ||
        // For the native GeneratorFunction constructor, the best we can
        // do is to check its .name property.
        (ctor.displayName || ctor.name) === "GeneratorFunction"
      : false;
  };

  exports.mark = function(genFun) {
    if (Object.setPrototypeOf) {
      Object.setPrototypeOf(genFun, GeneratorFunctionPrototype);
    } else {
      genFun.__proto__ = GeneratorFunctionPrototype;
      if (!(toStringTagSymbol in genFun)) {
        genFun[toStringTagSymbol] = "GeneratorFunction";
      }
    }
    genFun.prototype = Object.create(Gp);
    return genFun;
  };

  // Within the body of any async function, `await x` is transformed to
  // `yield regeneratorRuntime.awrap(x)`, so that the runtime can test
  // `hasOwn.call(value, "__await")` to determine if the yielded value is
  // meant to be awaited.
  exports.awrap = function(arg) {
    return { __await: arg };
  };

  function AsyncIterator(generator) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);
      if (record.type === "throw") {
        reject(record.arg);
      } else {
        var result = record.arg;
        var value = result.value;
        if (value &&
            typeof value === "object" &&
            hasOwn.call(value, "__await")) {
          return Promise.resolve(value.__await).then(function(value) {
            invoke("next", value, resolve, reject);
          }, function(err) {
            invoke("throw", err, resolve, reject);
          });
        }

        return Promise.resolve(value).then(function(unwrapped) {
          // When a yielded Promise is resolved, its final value becomes
          // the .value of the Promise<{value,done}> result for the
          // current iteration.
          result.value = unwrapped;
          resolve(result);
        }, function(error) {
          // If a rejected Promise was yielded, throw the rejection back
          // into the async generator function so it can be handled there.
          return invoke("throw", error, resolve, reject);
        });
      }
    }

    var previousPromise;

    function enqueue(method, arg) {
      function callInvokeWithMethodAndArg() {
        return new Promise(function(resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise =
        // If enqueue has been called before, then we want to wait until
        // all previous Promises have been resolved before calling invoke,
        // so that results are always delivered in the correct order. If
        // enqueue has not been called before, then it is important to
        // call invoke immediately, without waiting on a callback to fire,
        // so that the async generator function has the opportunity to do
        // any necessary setup in a predictable way. This predictability
        // is why the Promise constructor synchronously invokes its
        // executor callback, and why async functions synchronously
        // execute code before the first await. Since we implement simple
        // async functions in terms of async generators, it is especially
        // important to get this right, even though it requires care.
        previousPromise ? previousPromise.then(
          callInvokeWithMethodAndArg,
          // Avoid propagating failures to Promises returned by later
          // invocations of the iterator.
          callInvokeWithMethodAndArg
        ) : callInvokeWithMethodAndArg();
    }

    // Define the unified helper method that is used to implement .next,
    // .throw, and .return (see defineIteratorMethods).
    this._invoke = enqueue;
  }

  defineIteratorMethods(AsyncIterator.prototype);
  AsyncIterator.prototype[asyncIteratorSymbol] = function () {
    return this;
  };
  exports.AsyncIterator = AsyncIterator;

  // Note that simple async functions are implemented on top of
  // AsyncIterator objects; they just return a Promise for the value of
  // the final result produced by the iterator.
  exports.async = function(innerFn, outerFn, self, tryLocsList) {
    var iter = new AsyncIterator(
      wrap(innerFn, outerFn, self, tryLocsList)
    );

    return exports.isGeneratorFunction(outerFn)
      ? iter // If outerFn is a generator, return the full iterator.
      : iter.next().then(function(result) {
          return result.done ? result.value : iter.next();
        });
  };

  function makeInvokeMethod(innerFn, self, context) {
    var state = GenStateSuspendedStart;

    return function invoke(method, arg) {
      if (state === GenStateExecuting) {
        throw new Error("Generator is already running");
      }

      if (state === GenStateCompleted) {
        if (method === "throw") {
          throw arg;
        }

        // Be forgiving, per 25.3.3.3.3 of the spec:
        // https://people.mozilla.org/~jorendorff/es6-draft.html#sec-generatorresume
        return doneResult();
      }

      context.method = method;
      context.arg = arg;

      while (true) {
        var delegate = context.delegate;
        if (delegate) {
          var delegateResult = maybeInvokeDelegate(delegate, context);
          if (delegateResult) {
            if (delegateResult === ContinueSentinel) continue;
            return delegateResult;
          }
        }

        if (context.method === "next") {
          // Setting context._sent for legacy support of Babel's
          // function.sent implementation.
          context.sent = context._sent = context.arg;

        } else if (context.method === "throw") {
          if (state === GenStateSuspendedStart) {
            state = GenStateCompleted;
            throw context.arg;
          }

          context.dispatchException(context.arg);

        } else if (context.method === "return") {
          context.abrupt("return", context.arg);
        }

        state = GenStateExecuting;

        var record = tryCatch(innerFn, self, context);
        if (record.type === "normal") {
          // If an exception is thrown from innerFn, we leave state ===
          // GenStateExecuting and loop back for another invocation.
          state = context.done
            ? GenStateCompleted
            : GenStateSuspendedYield;

          if (record.arg === ContinueSentinel) {
            continue;
          }

          return {
            value: record.arg,
            done: context.done
          };

        } else if (record.type === "throw") {
          state = GenStateCompleted;
          // Dispatch the exception by looping back around to the
          // context.dispatchException(context.arg) call above.
          context.method = "throw";
          context.arg = record.arg;
        }
      }
    };
  }

  // Call delegate.iterator[context.method](context.arg) and handle the
  // result, either by returning a { value, done } result from the
  // delegate iterator, or by modifying context.method and context.arg,
  // setting context.delegate to null, and returning the ContinueSentinel.
  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];
    if (method === undefined) {
      // A .throw or .return when the delegate iterator has no .throw
      // method always terminates the yield* loop.
      context.delegate = null;

      if (context.method === "throw") {
        // Note: ["return"] must be used for ES3 parsing compatibility.
        if (delegate.iterator["return"]) {
          // If the delegate iterator has a return method, give it a
          // chance to clean up.
          context.method = "return";
          context.arg = undefined;
          maybeInvokeDelegate(delegate, context);

          if (context.method === "throw") {
            // If maybeInvokeDelegate(context) changed context.method from
            // "return" to "throw", let that override the TypeError below.
            return ContinueSentinel;
          }
        }

        context.method = "throw";
        context.arg = new TypeError(
          "The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);

    if (record.type === "throw") {
      context.method = "throw";
      context.arg = record.arg;
      context.delegate = null;
      return ContinueSentinel;
    }

    var info = record.arg;

    if (! info) {
      context.method = "throw";
      context.arg = new TypeError("iterator result is not an object");
      context.delegate = null;
      return ContinueSentinel;
    }

    if (info.done) {
      // Assign the result of the finished delegate to the temporary
      // variable specified by delegate.resultName (see delegateYield).
      context[delegate.resultName] = info.value;

      // Resume execution at the desired location (see delegateYield).
      context.next = delegate.nextLoc;

      // If context.method was "throw" but the delegate handled the
      // exception, let the outer generator proceed normally. If
      // context.method was "next", forget context.arg since it has been
      // "consumed" by the delegate iterator. If context.method was
      // "return", allow the original .return call to continue in the
      // outer generator.
      if (context.method !== "return") {
        context.method = "next";
        context.arg = undefined;
      }

    } else {
      // Re-yield the result returned by the delegate method.
      return info;
    }

    // The delegate iterator is finished, so forget it and continue with
    // the outer generator.
    context.delegate = null;
    return ContinueSentinel;
  }

  // Define Generator.prototype.{next,throw,return} in terms of the
  // unified ._invoke helper method.
  defineIteratorMethods(Gp);

  Gp[toStringTagSymbol] = "Generator";

  // A Generator should always return itself as the iterator object when the
  // @@iterator function is called on it. Some browsers' implementations of the
  // iterator prototype chain incorrectly implement this, causing the Generator
  // object to not be returned from this call. This ensures that doesn't happen.
  // See https://github.com/facebook/regenerator/issues/274 for more details.
  Gp[iteratorSymbol] = function() {
    return this;
  };

  Gp.toString = function() {
    return "[object Generator]";
  };

  function pushTryEntry(locs) {
    var entry = { tryLoc: locs[0] };

    if (1 in locs) {
      entry.catchLoc = locs[1];
    }

    if (2 in locs) {
      entry.finallyLoc = locs[2];
      entry.afterLoc = locs[3];
    }

    this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal";
    delete record.arg;
    entry.completion = record;
  }

  function Context(tryLocsList) {
    // The root entry object (effectively a try statement without a catch
    // or a finally block) gives us a place to store values thrown from
    // locations where there is no enclosing try statement.
    this.tryEntries = [{ tryLoc: "root" }];
    tryLocsList.forEach(pushTryEntry, this);
    this.reset(true);
  }

  exports.keys = function(object) {
    var keys = [];
    for (var key in object) {
      keys.push(key);
    }
    keys.reverse();

    // Rather than returning an object with a next method, we keep
    // things simple and return the next function itself.
    return function next() {
      while (keys.length) {
        var key = keys.pop();
        if (key in object) {
          next.value = key;
          next.done = false;
          return next;
        }
      }

      // To avoid creating an additional object, we just hang the .value
      // and .done properties off the next function object itself. This
      // also ensures that the minifier will not anonymize the function.
      next.done = true;
      return next;
    };
  };

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) {
        return iteratorMethod.call(iterable);
      }

      if (typeof iterable.next === "function") {
        return iterable;
      }

      if (!isNaN(iterable.length)) {
        var i = -1, next = function next() {
          while (++i < iterable.length) {
            if (hasOwn.call(iterable, i)) {
              next.value = iterable[i];
              next.done = false;
              return next;
            }
          }

          next.value = undefined;
          next.done = true;

          return next;
        };

        return next.next = next;
      }
    }

    // Return an iterator with no values.
    return { next: doneResult };
  }
  exports.values = values;

  function doneResult() {
    return { value: undefined, done: true };
  }

  Context.prototype = {
    constructor: Context,

    reset: function(skipTempReset) {
      this.prev = 0;
      this.next = 0;
      // Resetting context._sent for legacy support of Babel's
      // function.sent implementation.
      this.sent = this._sent = undefined;
      this.done = false;
      this.delegate = null;

      this.method = "next";
      this.arg = undefined;

      this.tryEntries.forEach(resetTryEntry);

      if (!skipTempReset) {
        for (var name in this) {
          // Not sure about the optimal order of these conditions:
          if (name.charAt(0) === "t" &&
              hasOwn.call(this, name) &&
              !isNaN(+name.slice(1))) {
            this[name] = undefined;
          }
        }
      }
    },

    stop: function() {
      this.done = true;

      var rootEntry = this.tryEntries[0];
      var rootRecord = rootEntry.completion;
      if (rootRecord.type === "throw") {
        throw rootRecord.arg;
      }

      return this.rval;
    },

    dispatchException: function(exception) {
      if (this.done) {
        throw exception;
      }

      var context = this;
      function handle(loc, caught) {
        record.type = "throw";
        record.arg = exception;
        context.next = loc;

        if (caught) {
          // If the dispatched exception was caught by a catch block,
          // then let that catch block handle the exception normally.
          context.method = "next";
          context.arg = undefined;
        }

        return !! caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        var record = entry.completion;

        if (entry.tryLoc === "root") {
          // Exception thrown outside of any try block that could handle
          // it, so set the completion value of the entire function to
          // throw the exception.
          return handle("end");
        }

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc");
          var hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            } else if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            }

          } else if (hasFinally) {
            if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else {
            throw new Error("try statement without catch or finally");
          }
        }
      }
    },

    abrupt: function(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc <= this.prev &&
            hasOwn.call(entry, "finallyLoc") &&
            this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      if (finallyEntry &&
          (type === "break" ||
           type === "continue") &&
          finallyEntry.tryLoc <= arg &&
          arg <= finallyEntry.finallyLoc) {
        // Ignore the finally entry if control is not jumping to a
        // location outside the try/catch block.
        finallyEntry = null;
      }

      var record = finallyEntry ? finallyEntry.completion : {};
      record.type = type;
      record.arg = arg;

      if (finallyEntry) {
        this.method = "next";
        this.next = finallyEntry.finallyLoc;
        return ContinueSentinel;
      }

      return this.complete(record);
    },

    complete: function(record, afterLoc) {
      if (record.type === "throw") {
        throw record.arg;
      }

      if (record.type === "break" ||
          record.type === "continue") {
        this.next = record.arg;
      } else if (record.type === "return") {
        this.rval = this.arg = record.arg;
        this.method = "return";
        this.next = "end";
      } else if (record.type === "normal" && afterLoc) {
        this.next = afterLoc;
      }

      return ContinueSentinel;
    },

    finish: function(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) {
          this.complete(entry.completion, entry.afterLoc);
          resetTryEntry(entry);
          return ContinueSentinel;
        }
      }
    },

    "catch": function(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;
          if (record.type === "throw") {
            var thrown = record.arg;
            resetTryEntry(entry);
          }
          return thrown;
        }
      }

      // The context.catch method must only be called with a location
      // argument that corresponds to a known catch block.
      throw new Error("illegal catch attempt");
    },

    delegateYield: function(iterable, resultName, nextLoc) {
      this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      };

      if (this.method === "next") {
        // Deliberately forget the last sent value so that we don't
        // accidentally pass it on to the delegate.
        this.arg = undefined;
      }

      return ContinueSentinel;
    }
  };

  // Regardless of whether this script is executing as a CommonJS module
  // or not, return the runtime object so that we can declare the variable
  // regeneratorRuntime in the outer scope, which allows this module to be
  // injected easily by `bin/regenerator --include-runtime script.js`.
  return exports;

}(
  // If this script is executing as a CommonJS module, use module.exports
  // as the regeneratorRuntime namespace. Otherwise create a new empty
  // object. Either way, the resulting object will be used to initialize
  // the regeneratorRuntime variable at the top of this file.
   true ? module.exports : undefined
));

try {
  regeneratorRuntime = runtime;
} catch (accidentalStrictMode) {
  // This module should not be running in strict mode, so the above
  // assignment should always work unless something is misconfigured. Just
  // in case runtime.js accidentally runs in strict mode, we can escape
  // strict mode using a global Function call. This could conceivably fail
  // if a Content Security Policy forbids using Function, but in that case
  // the proper solution is to fix the accidental strict mode problem. If
  // you've misconfigured your bundler to force strict mode and applied a
  // CSP to forbid Function, and you're not willing to fix either of those
  // problems, please detail your unique predicament in a GitHub issue.
  Function("r", "regeneratorRuntime = r")(runtime);
}


/***/ }),

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

__webpack_require__(/*! ./bootstrap */ "./resources/js/bootstrap.js");

(function () {
  var calendar = document.querySelector('.js-calendar');

  if (calendar) {
    var selectDate = document.querySelector('.js-select_date');
    var monthNames = calendar.querySelectorAll('.js-calendar_header');
    var months = calendar.querySelectorAll('.js-calendar-month_item');
    var closeBtn = calendar.querySelector('.js-calendar-close');
    var today = calendar.querySelector('.calendar-selected');
    var startingName = monthNames[0];
    var startingMonth = months[0];
    var selectBtn = calendar.querySelector('.js-calendar-set_day');
    var hidden = document.querySelector('.js-form-hidden_input');
    startingName.classList.add('calendar-header--active');
    startingMonth.classList.add('calendar-month_item--active');

    var showCalendar = function showCalendar() {
      calendar.classList.add('calendar--active');
    };

    var close = function close() {
      var activeDay = calendar.querySelector('.calendar-selected');
      var activeName = calendar.querySelector('.calendar-header--active');
      var activeMonth = calendar.querySelector('.calendar-month_item--active');
      activeDay.classList.remove('calendar-selected');
      today.classList.add('calendar-selected');
      activeName.classList.remove('calendar-header--active');
      activeMonth.classList.remove('calendar-month_item--active');
      startingName.classList.add('calendar-header--active');
      startingMonth.classList.add('calendar-month_item--active');
      calendar.classList.remove('calendar--active');
    };

    var hideCalendar = function hideCalendar(e) {
      if (e.currentTarget === e.target || e.key === "Escape" || e.key === "Esc" || e.target.closest('.js-calendar-close')) {
        close();
      }
    };

    var nextMonth = function nextMonth(e) {
      if (e.target.closest('.js-calendar-select_month_btn')) {
        var direction = e.target.closest('.js-calendar-select_month_btn').dataset.direction;
        var activeName = calendar.querySelector('.calendar-header--active');
        var activeMonth = calendar.querySelector('.calendar-month_item--active');
        var nextName = direction === 'next' ? activeName.nextElementSibling : activeName.previousElementSibling;

        var _nextMonth = direction === 'next' ? activeMonth.nextElementSibling : activeMonth.previousElementSibling;

        if (nextName && _nextMonth) {
          var selected = calendar.querySelector('.calendar-selected');
          var date = selected.dataset.date;
          activeName.classList.remove('calendar-header--active');
          activeMonth.classList.remove('calendar-month_item--active');
          nextName.classList.add('calendar-header--active');

          _nextMonth.classList.add('calendar-month_item--active');

          var newDay = _nextMonth.querySelector('.js-calendar-select[data-date="' + date + '"]');

          if (newDay) {
            calendar.querySelectorAll('.calendar-selected').forEach(function (item) {
              return item.classList.remove('calendar-selected');
            });
            newDay.classList.add('calendar-selected');
          }
        }
      }
    };

    var chooseDay = function chooseDay(e) {
      var parent = e.target.closest('.js-calendar-day');

      if (parent) {
        var day = parent.querySelector('.js-calendar-select');

        if (day) {
          var newAttribute = day.dataset.date;
          var newMonth = new Date(newAttribute).getMonth() + 1;
          var currentMonth = calendar.querySelector('.calendar-month_item--active').dataset.month;
          var activeName = calendar.querySelector('.calendar-header--active');
          var activeMonth = calendar.querySelector('.calendar-month_item--active');
          var nextName = null;
          var _nextMonth2 = null;

          if (currentMonth != newMonth) {
            nextName = currentMonth > newMonth ? activeName.previousElementSibling : activeName.nextElementSibling;
            _nextMonth2 = currentMonth > newMonth ? activeMonth.previousElementSibling : activeMonth.nextElementSibling;

            if (nextName && _nextMonth2) {
              activeName.classList.remove('calendar-header--active');
              activeMonth.classList.remove('calendar-month_item--active');
              nextName.classList.add('calendar-header--active');

              _nextMonth2.classList.add('calendar-month_item--active');

              calendar.querySelectorAll('.calendar-selected').forEach(function (item) {
                return item.classList.remove('calendar-selected');
              });

              var newDay = _nextMonth2.querySelector('.js-calendar-select[data-date="' + newAttribute + '"]');

              newDay.classList.add('calendar-selected');
            }
          } else {
            calendar.querySelectorAll('.calendar-selected').forEach(function (item) {
              return item.classList.remove('calendar-selected');
            });
            day.classList.add('calendar-selected');
          }
        }
      }
    };

    var setDay = function setDay() {
      var selected = calendar.querySelector('.calendar-selected');
      var date = selected.dataset.date;
      hidden.value = date;
      var dateInstanse = new Date(date);
      var month = dateInstanse.getMonth() + 1 < 10 ? '0' + (dateInstanse.getMonth() + 1) : dateInstanse.getMonth() + 1;
      selectDate.textContent = "".concat(dateInstanse.getDate(), ".").concat(month, ".").concat(dateInstanse.getFullYear());
      selectDate.style.color = '#000000';
      startingName = calendar.querySelector('.calendar-header[data-monthname="' + (dateInstanse.getMonth() + 1) + '"]');
      startingMonth = calendar.querySelector('.calendar-month_item[data-month="' + (dateInstanse.getMonth() + 1) + '"]');
      today = startingMonth.querySelector('.js-calendar-select[data-date="' + date + '"]');
      close();
    };

    selectDate.addEventListener('click', showCalendar);
    calendar.addEventListener('click', hideCalendar);
    document.addEventListener('keydown', hideCalendar);
    closeBtn.addEventListener('click', hideCalendar);
    calendar.addEventListener('click', nextMonth);
    calendar.addEventListener('click', chooseDay);
    selectBtn.addEventListener('click', setDay);
  }
})();

(function () {
  var searchCityInputs = document.querySelectorAll('.js-form-search_city');

  if (searchCityInputs) {
    var cityLists = document.querySelectorAll('.js-form-city_list');

    var search =
    /*#__PURE__*/
    function () {
      var _ref = _asyncToGenerator(
      /*#__PURE__*/
      _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee(name) {
        var citiesJson;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return fetch("/ajax/city/".concat(name), {
                  headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                  }
                });

              case 2:
                citiesJson = _context.sent;
                _context.next = 5;
                return citiesJson.json();

              case 5:
                return _context.abrupt("return", _context.sent);

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }));

      return function search(_x) {
        return _ref.apply(this, arguments);
      };
    }();

    var searchCity = function searchCity(e) {
      var target = e.target;
      var cityList = target.closest('.js-form-input_group').querySelector('.js-form-city_list');

      var close = function close() {
        cityList.classList.remove('js-form-city_list--active');
        cityList.textContent = '';
      };

      if (target.value.length < 4) {
        close();
        return;
      }

      search(target.value.toLowerCase()).then(function (value) {
        if (value.length === 0 || value.length === 1 && value[0].toLowerCase() === target.value.toLowerCase()) {
          close();
          return;
        }

        cityList.textContent = '';
        var fragment = document.createDocumentFragment();
        value.forEach(function (city) {
          var li = document.createElement('li');
          li.classList.add('form-city_item');
          li.textContent = "".concat(city[0].toUpperCase()).concat(city.slice(1));
          fragment.appendChild(li);
        });
        cityList.appendChild(fragment);

        if (!cityList.classList.contains('js-form-city_list--active')) {
          cityList.classList.add('js-form-city_list--active');
        }

        setTimeout(function () {
          if (target.value.length < 4) {
            close();
          }
        }, 100);
      });
    };

    var closeCityList = function closeCityList(e) {
      if (!e.target.closest('.js-form-city_list--active') || e.key === "Escape" || e.key === "Esc") {
        var list = document.querySelector('.js-form-city_list--active');

        if (list) {
          list.classList.remove('js-form-city_list--active');
        }
      }
    };

    var setCity = function setCity(e) {
      var target = e.target;

      if (target.classList.contains('form-city_item')) {
        var input = target.closest('.js-form-input_group').querySelector('.js-form-search_city');
        input.value = target.textContent;
        target.closest('.js-form-city_list--active').classList.remove('js-form-city_list--active');
      }
    };

    searchCityInputs.forEach(function (input) {
      return input.addEventListener('input', searchCity);
    });
    cityLists.forEach(function (list) {
      return list.addEventListener('click', setCity);
    });
    document.addEventListener('click', closeCityList);
    document.addEventListener('keydown', closeCityList);
  }
})();

(function () {
  var inputs = _toConsumableArray(document.querySelectorAll('.js-input'));

  inputs.forEach(function (input) {
    return input.addEventListener('focus', function (e) {
      var target = e.currentTarget;
      var parent = target.closest('.is-invalid');

      if (parent) {
        parent.classList.remove('is-invalid');
        target.value = '';
        parent.removeChild(parent.querySelector('.form-error_message'));
      }
    });
  });
})();

(function () {
  var time = document.querySelector('.time');

  if (time) {
    var timeInput = document.querySelector('.js-select_time');
    var hiddenInput = document.querySelector('.js-form-hidden_time');
    var hours = time.querySelector('.js-time-hours');
    var minutes = time.querySelector('.js-time-minutes');
    var groups = time.querySelectorAll('.js-time-input_group');
    var setTimeBtn = time.querySelector('.js-time-set_time');
    var inputValue = '00';

    var onInput = function onInput(e) {
      var target = e.currentTarget;

      if (target.classList.contains('time-input--error')) {
        target.classList.remove('time-input--error');
      }

      var max = parseInt(target.dataset.max);

      if (target.value === '') {
        return;
      }

      var value = parseInt(target.value);

      if (!/^\d*$/.test(target.value) || value > max || target.value.length > 2) {
        target.value = inputValue;
        return;
      }

      inputValue = target.value;
      target.value = inputValue;
    };

    var onChange = function onChange(e) {
      var value = e.currentTarget.value;

      if (value === '') {
        e.currentTarget.value = '00';
        return;
      }

      if (parseInt(e.currentTarget.value) < 10 && value.length < 2) {
        e.currentTarget.value = '0' + value;
      }
    };

    var onBtnClick = function onBtnClick(e) {
      var target = e.target;
      var btn = target.closest('.js-time-btn');

      if (btn) {
        var direction = btn.dataset.direction;
        var input = e.target.closest('.js-time-input_group').querySelector('input');

        if (input.classList.contains('time-input--error')) {
          input.classList.remove('time-input--error');
        }

        var max = parseInt(input.dataset.max);
        var value = input.value === '' ? 0 : parseInt(input.value);

        if (direction === 'up' && value === max) {
          value = 0;
        } else if (direction === 'down' && value === 0) {
          value = max;
        } else {
          direction === 'up' ? value++ : value--;
        }

        input.value = value < 10 ? '0' + value : value;
      }
    };

    var onSetTime = function onSetTime() {
      groups.forEach(function (group) {
        var input = group.querySelector('input');

        if (input.value === '') {
          input.classList.add('time-input--error');
          return;
        }

        timeInput.textContent = hours.value + ':' + minutes.value;
        timeInput.style.color = '#000000';
        hiddenInput.value = hours.value + ':' + minutes.value + ':00';
        time.classList.remove('time--active');
      });
    };

    var close = function close(e) {
      if (e.target.closest('.js-time-close') || e.target.classList.contains('js-time') || e.key === "Escape" || e.key === "Esc") {
        time.classList.remove('time--active');
      }
    };

    timeInput.addEventListener('click', function () {
      return time.classList.add('time--active');
    });
    hours.addEventListener('input', onInput);
    minutes.addEventListener('input', onInput);
    hours.addEventListener('change', onChange);
    minutes.addEventListener('change', onChange);
    groups.forEach(function (group) {
      return group.addEventListener('click', onBtnClick);
    });
    setTimeBtn.addEventListener('click', onSetTime);
    document.addEventListener('click', close);
    document.addEventListener('keydown', close);
  }
})();

(function () {
  var table = document.querySelector('.table');

  if (table) {
    var popup = document.querySelector('.js-delete_item');

    var removeTicket = function removeTicket(e) {
      if (e.target.classList.contains('js-table-remove')) {
        var url = e.target.dataset.url;
        popup.classList.add('delete_item--active');
        popup.querySelector('.js-delete_item_form').setAttribute('action', url);
      }
    };

    var close = function close(e) {
      if (e.target.closest('.js-delete_item-close') || e.target.classList.contains('js-delete_item') || e.key === "Escape" || e.key === "Esc") {
        popup.classList.remove('delete_item--active');
      }
    };

    table.addEventListener('click', removeTicket);
    document.addEventListener('click', close);
    document.addEventListener('keydown', close);
  }
})();

(function () {
  var popup = document.querySelector('.js-delete_user');

  if (popup) {
    var deleteBtn = document.querySelector('.js-delete_profile-btn');

    var deleteUser = function deleteUser(e) {
      var url = e.currentTarget.dataset.url;
      popup.classList.add('delete_user--active');
      popup.querySelector('.js-delete_user_form').setAttribute('action', url);
    };

    var close = function close(e) {
      if (e.target.closest('.js-delete_user-close') || e.target.classList.contains('delete_user') || e.key === "Escape" || e.key === "Esc") {
        popup.classList.remove('delete_user--active');
      }
    };

    deleteBtn.addEventListener('click', deleteUser);
    document.addEventListener('click', close);
    document.addEventListener('keydown', close);
  }
})();

(function () {
  var showBtn = document.querySelector('.js-admin-search_show');
  var search = document.querySelector('.js-admin-search_wrapper');

  if (search && showBtn) {
    showBtn.addEventListener('click', function () {
      search.classList.add('admin-search_wrapper--active');
      document.body.style.overflow = 'hidden';
      search.style.overflowX = 'hidden';
    });
    search.querySelector('.js-admin-search_form').addEventListener('click', function (e) {
      if (e.target.closest('.js-clear_value')) {
        var parent = e.target.closest('.form-input_group');
        var name = e.target.dataset.name;
        document.querySelector("input[name=\"".concat(name, "\"]")).value = '';
        var p = parent.querySelector('p.js-input');

        if (p) {
          p.textContent = name === 'date' ? 'Дата' : 'Время';
          p.style.color = '#636363';
        }
      }
    });

    var close = function close(e) {
      if (e.target.closest('.js-admin-search_form_close') || e.target.classList.contains('js-admin-search_wrapper') || e.key === "Escape" || e.key === "Esc") {
        search.classList.remove('admin-search_wrapper--active');
        document.body.style.overflow = 'auto';
        search.style.overflowX = 'auto';
      }
    };

    document.addEventListener('click', close);
    document.addEventListener('keydown', close);
  }
})();

(function () {
  var table = document.querySelector('.js-table_users');

  if (table) {
    var change =
    /*#__PURE__*/
    function () {
      var _ref2 = _asyncToGenerator(
      /*#__PURE__*/
      _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2(url) {
        var statusJson;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return fetch(url, {
                  headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                  }
                });

              case 2:
                statusJson = _context2.sent;
                _context2.next = 5;
                return statusJson.json();

              case 5:
                return _context2.abrupt("return", _context2.sent);

              case 6:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }));

      return function change(_x2) {
        return _ref2.apply(this, arguments);
      };
    }();

    var toggleStatus = function toggleStatus(e) {
      if (e.target.classList.contains('js-toggle_status')) {
        var url = e.target.dataset.link;
        change(url).then(function (statusObject) {
          e.target.textContent = statusObject.status === 'waiting' ? 'Ожидание' : 'Прибыл';
        });
      }
    };

    table.addEventListener('click', toggleStatus);
  }
})();

(function () {
  var form = document.querySelector('.js-admin-search_form');
  var hiddenCheckbox = document.querySelector('.js-checkbox-hidden');

  if (form && hiddenCheckbox) {
    form.addEventListener('click', function (e) {
      var parent = e.target.closest('.js-checkbox');

      if (parent) {
        parent.querySelector('.js-checkbox-btn').classList.toggle('checkbox-btn--active');

        if (hiddenCheckbox.checked) {
          hiddenCheckbox.removeAttribute('checked');
          return;
        }

        hiddenCheckbox.setAttribute('checked', true);
      }
    });
  }
})();

(function () {
  var select = document.querySelector('.js-select_element');

  if (select) {
    select.addEventListener('click', function (e) {
      if (!e.currentTarget.classList.contains('select_element-list--active')) {
        e.currentTarget.classList.add('select_element-list--active');
      } else {
        var target = e.target;

        if (target.classList.contains('js-select_element-item') && !target.classList.contains('select_element-current')) {
          var role = target.dataset.role;

          _toConsumableArray(select.querySelectorAll('.js-select_element-item')).forEach(function (item) {
            item.classList.remove('select_element-current');
          });

          _toConsumableArray(document.querySelectorAll('.js-select_element-hidden option')).forEach(function (item) {
            item.removeAttribute('checked');
          });

          select.querySelector(".js-select_element-item[data-role=\"".concat(role, "\"]")).classList.add('select_element-current');
          document.querySelector(".js-select_element-hidden option[data-role=\"".concat(role, "\"]")).setAttribute('checked', 'true');
          select.querySelector('.js-select_element-selected').textContent = select.querySelector(".js-select_element-item[data-role=\"".concat(role, "\"]")).textContent;
        }

        e.currentTarget.classList.remove('select_element-list--active');
      }
    });
    document.addEventListener('click', function (e) {
      var selectList = e.target.closest('.select_element-list--active');
      var active = document.querySelector('.select_element-list--active');

      if (!selectList && active) {
        active.classList.remove('select_element-list--active');
      }
    });
  }
})();

/***/ }),

/***/ "./resources/js/bootstrap.js":
/*!***********************************!*\
  !*** ./resources/js/bootstrap.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/vagrant/service/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /home/vagrant/service/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });