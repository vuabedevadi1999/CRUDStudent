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
                            <div v-if="errors" class="bg-red-300">
                                <div v-for="(v, k) in errors" :key="k" class="alert alert-danger" role="alert">
                                    <span v-for="error in v" :key="error" class="text-sm">
                                        {{ error }}
                                    </span>
                                </div>
                            </div>
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
                            <div v-if="errors" class="bg-red-300">
                                <div v-for="(v, k) in errors" :key="k" class="alert alert-danger" role="alert">
                                    <span v-for="error in v" :key="error" class="text-sm">
                                        {{ error }}
                                    </span>
                                </div>
                            </div>
                            <ValidationObserver v-slot="{ handleSubmit }">
                                <form @submit.prevent="handleSubmit(updateStudent)">
                                    <ValidationProvider name="fullname" rules="required"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="name">Họ và tên</label>
                                            <input v-model="oldStudent.editName" type="text" class="form-control" id="editName" placeholder="Enter name">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <ValidationProvider name="email" rules="required|email"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="email">Địa chỉ email</label>
                                            <input v-model="oldStudent.editEmail" type="email" class="form-control" id="editEmail" placeholder="Enter email">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <ValidationProvider name="phone" rules="required|phone"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="phone">Số điện thoại</label>
                                            <input v-model="oldStudent.editPhone" type="text" class="form-control" id="editPhone" placeholder="Enter phone">
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
            <div class="col-md-12 mt-2">
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
                                <tr v-for="student in studentData.data" :key="student.id">
                                    <th scope="row">{{student.id}}</th>
                                    <td>{{ student.name }}</td>
                                    <td>{{ student.email }}</td>
                                    <td>{{ student.phone }}</td>
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
import axios from 'axios';
export default {
    name: "StudentList",
    components: {
        ValidationProvider,
        ValidationObserver
    },
    data(){
        return {
            errors : null,
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
        if(this.$store.state.token != ''){
            axios.post('/api/checkToken')
                .then(response=>{
                    if(response){
                        this.loading = false;
                        this.getAllStudent();
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
            axios.post('/api/students',this.student)
                .then(response=>{
                    this.student.name = ''
                    this.student.email = ''
                    this.student.phone = ''
                    this.getAllStudent();
                })
                .catch(err=>{
                    this.errors = err.response.data.errors;
                })
        },
        editStudent(id){
            axios.get('/api/students/'+ id) 
                .then(response => {
                    this.oldStudent.id = response.data.student.id
                    this.oldStudent.editName = response.data.student.name
                    this.oldStudent.editEmail = response.data.student.email
                    this.oldStudent.editPhone = response.data.student.phone
                })
                .catch(err => {
                    this.errors = err.response.data.errors;
                })
        },
        updateStudent(){
            var student = { 
                    name:this.oldStudent.editName,
                    email:this.oldStudent.editEmail,
                    phone:this.oldStudent.editPhone 
            };
            axios.put('/api/students/'+ this.oldStudent.id,student)
                .then(response => {
                    this.oldStudent.editName = ''
                    this.oldStudent.editEmail = ''
                    this.oldStudent.editPhone = ''
                    this.getAllStudent();
                })
        },
        deleteStudent(id){
            if(confirm("Bạn có muốn xóa sinh viên này không?")){
                axios.delete('/api/students/'+ id)
                    .then(response => {
                        this.getAllStudent();
                        alert(response.data.success)
                })
                .catch(error => console.log(error))
            }
        },
        getAllStudent(page = 1){
            axios.get('api/students?page='+ page)
                .then(response => {
                    this.studentData = response.data.students;
                })
                .catch(err => {
                    console.log(err.response);
                })
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