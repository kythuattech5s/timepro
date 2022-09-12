function _defineProperty(obj, key, value) {
    if (key in obj) {
        Object.defineProperty(obj, key, {
            value: value,
            enumerable: true,
            configurable: true,
            writable: true,
        });
    } else {
        obj[key] = value;
    }
    return obj;
}
class CountDown {
    constructor(elm, time, showText = true) {
        _defineProperty(this, "endTime", void 0);
        _defineProperty(this, "currentElment", void 0);
        _defineProperty(this, "intervalLoopTime", void 0);
        _defineProperty(this, "showText", void 0);
        this.showText = showText;
        this.currentElment = elm;
        var endtime = new Date();
        endtime.setSeconds(endtime.getSeconds() + parseInt(time));
        this.endTime = endtime;
        return this;
    }
    setCallback(callBack, optionCallBacks = []) {
        this.callBack = callBack;
        this.optionCallBacks = optionCallBacks;
    }
    start() {
        if (this.currentElment.length == 0) return;
        var _this = this;
        this.intervalLoopTime = setInterval(function () {
            _this.loopTime();
        }, 1000);
    }
    stop() {
        clearInterval(this.intervalLoopTime);
    }
    callFunction(func, options = []) {
        var arrayFunc = func.split(".");
        if (arrayFunc.length === 1) {
            var func = arrayFunc[0];
            return (
                null != window[func] &&
                typeof window[func] === "function" &&
                window[func](...options)
            );
        } else if (arrayFunc.length === 2) {
            var obj = arrayFunc[0];
            func = arrayFunc[1];
            return (
                window[obj] != null &&
                typeof window[obj] === "object" &&
                null != window[obj][func] &&
                typeof window[obj][func] === "function" &&
                window[obj][func](...options)
            );
        }
    }
    loopTime() {
        var t = this.getTimeRemaining();
        if (t.seconds < 10) {
            t.seconds = "0" + t.seconds;
        }
        if (t.minutes < 10) {
            t.minutes = "0" + t.minutes;
        }
        if (t.hours < 10 && t.days < 1) {
            t.hours = "0" + t.hours;
        }
        if (this.showText) {
            if (t.days > 0) {
                var time_is = `<span>${t.days}d </span><span>${t.hours}h</span>:<span>${t.minutes}'</span>:<span>${t.seconds}s</span>`;
            } else {
                if (parseInt(t.hours) > 0) {
                    var time_is = `<span>${t.hours}h</span>:<span>${t.minutes}'</span>:<span>${t.seconds}s</span>`;
                } else {
                    var time_is = `<span>${t.minutes}'</span>:<span>${t.seconds}s</span>`;
                }
            }
        } else {
            if (t.days > 0) {
                var time_is = `<span>${t.days}</span><span>${t.hours}</span>:<span>${t.minutes}</span>:<span>${t.seconds}</span>`;
            } else {
                if (parseInt(t.hours) > 0) {
                    var time_is = `<span>${t.hours}</span>:<span>${t.minutes}</span>:<span>${t.seconds}</span>`;
                } else {
                    var time_is = `<span>${t.minutes}</span>:<span>${t.seconds}</span>`;
                }
            }
        }
        if (t.days == 0 && t.hours == 0 && t.minutes == 0 && t.seconds == 0) {
            if (typeof this.callBack != "undefined") {
                this.callFunction(this.callBack, this.optionCallBacks);
            }
            this.stop();
        } else {
            this.currentElment.html(time_is);
        }
    }
    getTimeRemaining() {
        var currenttime = new Date();
        var t = this.endTime - currenttime;
        t = t > 0 ? t : 0;
        var seconds = Math.floor((t / 1000) % 60);
        var minutes = Math.floor((t / 1000 / 60) % 60);
        var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
        var days = Math.floor(t / (1000 * 60 * 60 * 24));
        return {
            total: t,
            days: days,
            hours: hours,
            minutes: minutes,
            seconds: seconds,
        };
    }
}
