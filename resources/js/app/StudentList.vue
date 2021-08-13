<template>
    <div class="students">
        <div v-if="loading">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div v-else>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createStudent">
            Tạo mới sinh viên
            </button>
            <!-- Modal create student-->
            <div class="modal fade" id="createStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Thêm sinh viên</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ValidationObserver v-slot="{ handleSubmit }">
                                <form @submit.prevent="handleSubmit(saveStudent)">
                                    <ValidationProvider name="fullname" rules="required"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="name">Họ và tên</label>
                                            <input v-model="student.name" type="text" class="form-control" id="name" placeholder="Enter name">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <ValidationProvider name="email" rules="required|email"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="email">Địa chỉ email</label>
                                            <input v-model="student.email" type="email" class="form-control" id="email" placeholder="Enter email">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <ValidationProvider name="phone" rules="required|phone"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="phone">Số điện thoại</label>
                                            <input v-model="student.phone" type="text" class="form-control" id="phone" placeholder="Enter phone">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </ValidationObserver>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal edit student -->
            <div class="modal fade" id="editStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Chỉnh sửa sinh viên</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ValidationObserver v-slot="{ handleSubmit }">
                                <form @submit.prevent="handleSubmit(updateStudent)">
                                    <ValidationProvider name="fullname" rules="required"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="name">Họ và tên</label>
                                            <input v-model="oldStudent.name" type="text" class="form-control" id="editName" placeholder="Enter name">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <ValidationProvider name="email" rules="required|email"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="email">Địa chỉ email</label>
                                            <input v-model="oldStudent.email" type="email" class="form-control" id="editEmail" placeholder="Enter email">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <ValidationProvider name="phone" rules="required|phone"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="phone">Số điện thoại</label>
                                            <input v-model="oldStudent.phone" type="text" class="form-control" id="editPhone" placeholder="Enter phone">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </ValidationObserver>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-info" @click="logout">Dang xuat</button>
            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header">Danh sách sinh viên</div>
                    <div class="card-body">
                       <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Họ và tên</th>
                                <th scope="col">Email</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">id</th>
                                    <td>name</td>
                                    <td>email</td>
                                    <td>phone</td>
                                    <td>
                                        <button type="button" @click="editStudent(student.id)" class="btn btn-primary" data-toggle="modal" data-target="#editStudent">
                                        Edit
                                        </button>
                                        <button type="button" @click="deleteStudent(student.id)" class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination :data="studentData" @pagination-change-page="getAllStudent"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>
<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
export default {
    name: "StudentList",
    components: {
        ValidationProvider,
        ValidationObserver
    },
    data(){
        return {
            loading:true,
            student: {
                name:'',
                email:'',
                phone:''
            },
            oldStudent: {
                id:'',
                editName:'',
                editEmail:'',
                editPhone:''
            },
            studentData:{}
        }
    },
    mounted(){
        this.getAllStudent();
        if(this.$store.state.token!= ''){
            axios.post('/api/checkToken')
                .then(response=>{
                    if(response){
                        this.loading = false;
                    }
                })
                .catch(err=>{
                    this.loading = false;
                    this.$store.commit('clearToken');
                    this.$store.commit('clearUser');
                    this.$router.push('login');//chuyen sang trang login
                })
        }else{
            this.loading = false;
            this.$router.push('login');//chuyen sang trang login
        }
    },
    methods:{
        saveStudent(){

        },
        editStudent(id){

        },
        updateStudent(){

        },
        deleteStudent(id){

        },
        getAllStudent(page=1){

        },
        logout(){
            axios.post('api/logout')
                .then(response=>{
                    if(response){
                        this.$store.commit('clearToken');
                        this.$store.commit('clearUser');
                        this.$router.push('/');//chuyen sang trang login
                    }
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