import { initializeApp } from "https://www.gstatic.com/firebasejs/9.8.4/firebase-app.js";
import {
    getAuth,
    RecaptchaVerifier,
    signInWithPhoneNumber,
} from "https://www.gstatic.com/firebasejs/9.8.4/firebase-auth.js";

const defaultConfig = {
    eventNameSendCode: "firebase-send-code",
    eventNameCheckCodeSuccess: "firebase-confirm-code",
    eventNameCheckCode: "firebase-check-code",
};

class FIREBASE_AUTH {
    constructor(options = defaultConfig, firebaseConfig) {
        this.options = { ...defaultConfig, ...options };
        this.firebaseConfig = firebaseConfig;
        this.init();
    }

    init = () => {
        this.app = initializeApp(this.firebaseConfig);
        this.auth = getAuth(this.app);
        this.listenEventCustom();
        this.listenEventConfirmCode();
    };

    listenEventCustom = () => {
        window.addEventListener(this.options.eventNameSendCode, (e) => {
            const phoneNumber = e.detail.data;
            const button = e.detail.button;
            const callback = e.detail.callback;
            this.sendOTP(button, phoneNumber, callback);
        });
    };

    sendOTP = async (button, phoneNumber, cb) => {
        if (typeof window.recaptchaVerifier == "undefined") {
            window.recaptchaVerifier = new RecaptchaVerifier(
                button,
                {
                    size: "invisible",
                    callback: () => {},
                },
                this.auth
            );
        }
        
        try {
            const confirmationResult = await signInWithPhoneNumber(
                this.auth,
                phoneNumber.replace("0", "+84"),
                window.recaptchaVerifier
            );
            window.confirmationResult = confirmationResult;
            this.callFunction(cb, [button, phoneNumber]);
        } catch (error) {
            if (typeof mySupport != "undefined") {
                if (error.code == "auth/too-many-requests") {
                    return mySupport.showNotify(
                        100,
                        "Vui lòng thử lại sau số điện thoại này đã gửi quá số lần quy định!"
                    );
                }
                mySupport.showNotify(100, "Kiểm tra lại số điện thoại!");
            }
        }
    };

    listenEventConfirmCode = () => {
        window.addEventListener(this.options.eventNameCheckCode, async (e) => {
            const res = e.detail;
            try {
                const result = await window.confirmationResult.confirm(res.otp);
                window.dispatchEvent(
                    new CustomEvent(this.options.eventNameCheckCodeSuccess, {
                        detail: {
                            phone: result.user.phoneNumber.replace("+84", "0"),
                            code: res.otp,
                            isSuccess: true,
                        },
                    })
                );
            } catch (error) {
                if (typeof mySupport != "undefined") {
                    mySupport.showNotify(100, "Mã OTP không chính xác!");
                }
            }
        });
    };

    callFunction = (func, options = []) => {
        try {
            var arrayFunc = func.split(".");
            if (
                arrayFunc.length === 1 &&
                null != window[arrayFunc[0]] &&
                typeof window[arrayFunc[0]] === "function"
            ) {
                return (
                    null != window[arrayFunc[0]] &&
                    typeof window[arrayFunc[0]] === "function" &&
                    window[arrayFunc[0]](...options)
                );
            } else if (arrayFunc.length === 2) {
                var obj = arrayFunc[0];
                func = arrayFunc[1];
                const classEval =
                    typeof eval(`${obj}`) === "object"
                        ? eval(`${obj}`)
                        : eval(`new ${obj}()`);
                if (
                    typeof classEval === "object" &&
                    typeof classEval[func] === "function"
                ) {
                    return (
                        typeof classEval[func] === "function" &&
                        classEval[func](...options)
                    );
                } else if (
                    window[obj] === "object" &&
                    typeof window[obj][func] === "function"
                ) {
                    return (
                        window[obj] === "object" &&
                        typeof window[obj][func] === "function" &&
                        window[obj][func](...options)
                    );
                }
            }
        } catch (err) {
            console.log(err);
            alert(
                "Sửa lại data-success, Chưa đúng định dạng Object Function hoặc Class Function"
            );
        }
    };
}

export default FIREBASE_AUTH;
