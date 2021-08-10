<template>
    <div>
        <div v-if="loading">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="login" v-else>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Dang nhap</div>
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input v-model="credentials.email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                    <div class="invalid-feedback" v-model="errorEmail">{{errorEmail}}</div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input v-model="credentials.password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                    <div class="invalid-feedback" v-model="errorPassword">{{errorPassword}}</div>
                                </div>
                                <button type="submit" @click.prevent="login" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    name: "Login",
    data(){ 
        return {
            errorEmail: '',
            errorPassword:'',
            reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
            credentials: {
                email: '',
                password: '',
            },
            loading: true,
        }
    },
    mounted(){
        if(this.$store.state.token!= ''){
            axios.post('/api/checkToken',{token : this.$store.state.token})
                .then(response=>{
                    if(response){
                        console.log(this.$store.state.token);
                        this.loading = false;
                        this.$router.push('students');
                    }
                })
                .catch(err=>{
                    this.loading = false;
                    this.$store.commit('clearToken');
                })
        }else{
            this.loading = false
        }
    },
    methods : {
        validateFormLogin(){
                if(!this.credentials.email){
                    this.errorEmail = "Email khong duoc de trong"
                }else{
                    this.errorEmail = ''
                }
                if(!this.credentials.password){
                    this.errorPassword = "Mat khau khong duoc de trong"
                }else{
                    if(this.credentials.password.length<=6){
                        this.errorPassword = "Mat khau phai lon hon 6 ky tu"
                    }else{
                        this.errorPassword = ''
                    }
                }
                if(!this.reg.test(this.credentials.email)){
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
        login(){
            if(this.validateFormLogin() == true){
                //call api
                axios.post('api/login',this.credentials)
                .then(response=>{
                    if(response.data.success){
                        this.$store.commit('setToken',response.data.token)
                        this.$router.push('/students');
                    }
                })
                .catch(err=>{
                    console.log('error')
                })
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