import { required, min , max ,confirmed} from "vee-validate/dist/rules";
import { extend, localize } from "vee-validate";
export const validateForm = {
    data(){
        return {
            validationRules:{
                ruleEmail:'required',
                rulePassword:'required|min:6|max:12',
                ruleRequired:'required',
                rulePasswordConfirm:'required|min:6|max:12|confirmed:profile.newPassword',
                rulePhone:'required|phone'
            }
        }
    },
}
extend("confirmed", confirmed);
extend("required", required);
const regex = {
    regEmail: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
    regPhone: /(0)[0-9]{9}$/
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
extend("min", min);
extend("max", max);
localize({
    en:{
        names: {
            fullname:'Họ và tên',
            email: "Địa chỉ email",
            password: "Mật khẩu",
            phone:'Số điện thoại'
        },
        messages:{
            min: "{_field_} cần tối thiểu {length} ký tự",
            max: "{_field_} không được phép quá {length} ký tự",
            required:"{_field_} không được để trống",
            email: "{_field_} không hợp lệ",
            phone: "{_field_} phải bắt đầu bằng 0 và có 10 chữ số",
            confirmed: "{_field_} không trùng khớp"
        }
    }
})

