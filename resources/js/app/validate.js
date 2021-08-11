import Vue from "vue";
import { extend, localize } from "vee-validate";
import { required, min , max } from "vee-validate/dist/rules";
import en from "vee-validate/dist/locale/en.json";


extend("required", required);

const regex = {
  regEmail: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
  regPhone: /(0)[0-9]{9}/
}
const regEmail = new RegExp(regex.regEmail);
const regPhone = new RegExp(regex.regPhone);
extend("email", {
    validate: value => {
        return regEmail.test(value)
    }
});
extend("phone", {
  validate: value => {
      return regPhone.test(value)
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
      password: "Mật khẩu",
      fullname:"Tên",
      phone: "Số điện thoại"
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
      },
      fullname: {
        required:"{_field_} không được để trống",
      },
      phone: {
        required: "{_field_} không được để trống",
        phone: "{_field_} phải bao gồm 10 chữ số và bắt đầu bằng số 0"
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
