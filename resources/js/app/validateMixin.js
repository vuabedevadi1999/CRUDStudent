import { required, min , max } from "vee-validate/dist/rules";
import { extend, localize } from "vee-validate";
import Vue from "vue";
import { ValidationProvider, ValidationObserver } from "vee-validate";
Vue.component('ValidationProvider',ValidationProvider);
Vue.component('ValidationObserver',ValidationObserver);
export const validateForm = {
    data(){
        return {
            validationRules:{
                ruleEmail:'required',
                rulePassword:'required|min:6|max:12',
            }
        }
    },
}
extend("required", required);
const regex = {regEmail: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/}
const reg = new RegExp(regex.regEmail);
extend("email", {
    validate: value => {
        return reg.test(value)
    }
});
extend("min", min);
extend("max", max);
localize({
    en:{
        names: {
            email: "Địa chỉ email",
            password: "Mật khẩu",
        },
        messages:{
            min: "{_field_} cần tối thiểu {length} ký tự",
            max: "{_field_} không được phép quá {length} ký tự",
            required:"{_field_} không được để trống",
            email: "{_field_} không hợp lệ"
        }
    }
})

