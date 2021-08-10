<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dang nhap</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input v-model="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                <div class="invalid-feedback" v-model="errorEmail">{{errorEmail}}</div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input v-model="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                <div class="invalid-feedback" v-model="errorPassword">{{errorPassword}}</div>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                            </div>
                            <button type="submit" @click.prevent="apiLogin" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                email:'',
                password:'',
                errorEmail:'',
                errorPassword:'',
                reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            validateFormLogin(){
                if(!this.email){
                    this.errorEmail = "Email khong duoc de trong"
                }else{
                    this.errorEmail = ''
                }
                if(!this.password){
                    this.errorPassword = "Mat khau khong duoc de trong"
                }else{
                    if(this.password.length<=6){
                        this.errorPassword = "Mat khau phai lon hon 6 ky tu"
                    }else{
                        this.errorPassword = ''
                    }
                }
                if(!this.reg.test(this.email)){
                    this.errorEmail = "Email khong hop le"
                }else{
                    this.errorEmail = ''
                }
                if(this.errorEmail || this.errorPassword){
                    return false;
                }else{
                    return true;
                }
            },
            apiLogin(){
                if(this.validateFormLogin() == true){
                    //call api
                }
            }
        }
    }
</script>
<style scoped>
.invalid-feedback{
    display:block;
    font-size:15px;
}
</style>
