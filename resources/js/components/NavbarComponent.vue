<template>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <router-link :to="{ name: 'home' }" class="navbar-brand">論壇</router-link>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul v-if="userInfo == ''" class="navbar-nav ml-auto">
                        <!-- Authentication Links -->       
                        <li class="nav-item">
                            <router-link :to="{ name: 'login' }" class="nav-link">登入</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'register' }" class="nav-link">註冊</router-link>
                        </li>
                    </ul>

                    <ul v-else class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="javascript:void;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 {{ userInfo.name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#"
                                    v-on:click="logoutHandler">
                                    登出
                                </a>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
</template>

<script>
export default {
    data() {
        return {
            
        }
    },
    computed: {
        userInfo() {
            // 取得vuex下的資料
            return this.$store.state.userInfo;
        }

    },
    methods: {
        logoutHandler() {
            this.$store.dispatch('USER_LOGOUT').then(res => {
                this.$router.replace('/').catch(e => {console.log('已在首頁')} )
            })
        },
    },
    mounted() {

    }
    
}
</script>