import Vue from "vue";
import { extend, localize } from "vee-validate";
import { required, min , max } from "vee-validate/dist/rules";
import en from "vee-validate/dist/locale/en.json";


extend("required", required);

const regex = {regEmail: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/}
const reg = new RegExp(regex.regEmail);
extend("email", {
    validate: value => {
        return reg.test(value)
    }
});

// Install min rule.
extend("min", min);

extend("max", max);

localize({
  en: {
    messages: en.messages,
    names: {
      email: "Địa chỉ email",
      password: "Mật khẩu"
    },
    fields: {
      password: {
        min: "{_field_} cần tối thiểu 6 ký tự",
        max: "{_field_} không được phép quá 12 ký tự",
        required:"{_field_} không được để trống",
      },
      email: {
        required:"{_field_} không được để trống",
        email: "{_field_} không hợp lệ"
      }
    }
  },
});

let LOCALE = "en";
Object.defineProperty(Vue.prototype, "locale", {
  get() {
    return LOCALE;
  },
  set(val) {
    LOCALE = val;
    localize(val);
  }
});
