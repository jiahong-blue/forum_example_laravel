<template>
    <div class="container">
        <div v-if="errorMessage != ''" class="alert alert-danger" role="alert">{{errorMessage.error}}</div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form @submit.prevent="loginHandler">

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="userInfo.email" value="" required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="userInfo.password" required autocomplete="current-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember" v-model="remeber"  :true-value="1" :true-false="0">

                                        <label class="form-check-label" for="remember">
                                            記住我
                                        </label>
                                    </div>
                                </div>
                            </div>              

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        登入
                                    </button>
                                    <!-- <a href="/login/google" class="btn btn-primary" target="_blank">
                                        <i style="white" class='fab fa-google'></i> Login
                                    </a> -->
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
                email: '',
                password: '',
            },
            remeber: 0,
            errorMessage: [],
        }

    },
    methods: {
        // dispatch到actions
        loginHandler() {
            let data = this.userInfo
            this.$store.dispatch('USER_LOGIN', { data } ).then(res => {
                // 有接收到錯誤資訊
                console.log(res)
                if(res) {
                    this.errorMessage = res
                } else {
                    // 判定要記住，存到local
                    if(this.remeber == 1) { 
                        let userInfo = this.$store.state.userInfo
                        localStorage.setItem('userInfo', JSON.stringify(userInfo))
                    }
                    // 回首頁
                    this.$router.push({ name: 'home' })
                }
                
            });
        },
    },
}
</script>