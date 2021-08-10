<template>
    <div class="students">
        <div v-if="loading">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div v-else>
            Đăng nhập thành công.List sinh viên
            <button class="btn btn-info" @click="logout">Dang xuat</button>
        </div>
    </div>
    
</template>
<script>
export default {
    name: "StudentList",
    data(){
        return {
            loading:true,
        }
    },
    mounted(){
        if(this.$store.state.token!= ''){
            axios.post('/api/checkToken',{token : this.$store.state.token})
                .then(response=>{
                    if(response){
                        this.loading = false;
                    }
                })
                .catch(err=>{
                    this.loading = false;
                    this.$store.commit('clearToken');
                    this.$router.push('login');//chuyen sang trang login
                })
        }else{
            this.loading = false;
            this.$router.push('login');//chuyen sang trang login
        }
    },
    methods:{
        logout(){
            axios.post('api/logout',{token : this.$store.state.token})
                .then(response=>{
                    if(response){
                        this.$store.commit('clearToken');
                        this.$router.push('/');//chuyen sang trang login
                    }
                })
        }
    }
}
</script>
<style scoped>

</style>