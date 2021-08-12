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
                            <div v-if="errors" class="bg-red-300">
                                <div v-for="(v, k) in errors" :key="k" class="alert alert-danger" role="alert">
                                    <span v-for="error in v" :key="error" class="text-sm">
                                        {{ error }}
                                    </span>
                                </div>
                            </div>
                            <ValidationObserver v-slot="{ handleSubmit }">
                                <form @submit.prevent="handleSubmit(login)">
                                    <ValidationProvider name="email" :rules="validationRules.ruleEmail" v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>                    
                                            <input v-model="credentials.email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                        </div>
                                     </ValidationProvider>
                                    <ValidationProvider name="password" :rules="validationRules.rulePassword" v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input v-model="credentials.password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                             </ValidationObserver>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { validateForm } from './validateMixin';
export default {
    mixins:[validateForm],
    name: "Login",
    data(){ 
        return {
            errors : null,
            credentials: {
                email: '',
                password: '',
            },
            loading: true,
        }
    },
    mounted(){
        if(this.$store.state.token!= ''){
            axios.post('/api/checkToken')
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
                    this.$store.commit('clearUser');
                })
        }else{
            this.loading = false
        }
    },
    methods : {
        login(){
            //call api
            axios.post('api/login',this.credentials)
            .then(response=>{
                if(response.data.success){
                    this.$store.commit('setToken',response.data.token)
                    this.$store.commit('setUser',response.data.user)
                    this.$router.push('/students');
                }
            })
            .catch(err=>{
                this.errors = err.response.data.errors;
            })
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