<template>
    <div>
        <div class="navbar">
            <div>
                <router-link to="/">Home</router-link>
            </div>
            <div>
                <router-link to="/login">Đăng nhập</router-link>
            </div>
            <div>
                <router-link to="/students">Danh sách sinh viên</router-link>
            </div>
        </div>
        <router-view></router-view>
    </div>
    
</template>
<script>
export default {
    name: "Home"
}
</script>
<style scoped>
    .navbar{
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #FFF;
        border-bottom: 1px solid #EEE ;
        color: blue;
    }
    .navbar div{
        padding: 10px 20px;
        margin: 5px;
    }
</style>