<template>
<div class="container">
    <div v-for="(el, index) in errorMessage" class="alert alert-danger" role="alert" :key="index">{{el[0]}}</div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Register</div>

                <div class="card-body">
                    <form @submit.prevent="registerHandler">

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">姓名</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" v-model.trim="userInfo.name" required autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" v-model.trim="userInfo.email" required autocomplete="email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">密碼</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" v-model.trim="userInfo.password" minlength="8" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">確認密碼</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" v-model.trim="userInfo.c_password" minlength="8" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    註冊
                                </button>
                                <router-link class="btn btn-danger" :to="{name: 'home'}">取消</router-link>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            userInfo: {
                name: '',
                email: '',
                password: '',
                c_password: '',
            },
            errorMessage: []
            
        }
    },

    methods: {
        // 使用vuex，需dispatch到action，讓其call api
        registerHandler() {

            if(!this.confirmPassword()) {
                this.errorMessage = {'error': ["密碼輸入不一致"]}
                return 
            }
            let data = this.userInfo
            this.$store.dispatch('USER_REGISTER', { data } ).then(res => {
                // 有接收到錯誤資訊
                if(res) {
                    this.errorMessage = res
                } else {
                    this.$router.push({ name: 'home' })
                }

            }).catch(e => {
                console.log(e)
            });
        },
        // 比對密碼是否一致
        confirmPassword() {
            return this.userInfo.password === this.userInfo.c_password
        }

    },

}
</script>

<style>

</style>