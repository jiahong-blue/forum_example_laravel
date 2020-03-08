import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';


Vue.use(Vuex);

const store = new Vuex.Store({
    // 開發模式，用較嚴格的，但耗效能
    // 不開會有state不會更新的問題
    // 一定要開，單向資料流很重要
    strict: true,

    // 存資料
    state: {
        userInfo: [],

    },

    // 接收由vue經dispatch過來的方法
    actions: {
        // 向後端call api取得註冊完資料
        USER_REGISTER(content, {data}) {

            return axios.post('/api/register', data).then(res => {
                // 藉由commit傳到mutation
                content.commit('user_set_info', res.data.data)
     
            }).catch(e => {
                // 有錯誤
                // 將資訊回給registerComponent
                return e.response.data.data
            });
        },
        // 向後端取得登入資料
        USER_LOGIN(content, {data}) {
            return axios.post('/api/login', data).then((res) => {
                // commit到mutation
                content.commit('user_set_info', res.data.data)

            }).catch(e => {
                // 有錯誤
                // 將資訊回給registerComponent
                return e.response.data.data
            });
        },

        // 登出
        USER_LOGOUT(content) {
            // commit mutation
            content.commit('user_remove_info');
        },

        // 確認是否登入
        USER_CHECK_LOGIN(content) {
            if(this.state.userInfo == '') {
                // 從local取user資料
                let local_userInfo = JSON.parse(localStorage.getItem('userInfo'))
                // 若有資料，commit到mutation
                if (local_userInfo) {
                    content.commit('user_set_info', local_userInfo)
                } 
            }
        },

    },

    mutations: {
        // 接收actions過來的資料，並更新state
        // 註冊及登入都更新同樣的資料
        user_set_info(state, data) {
            state.userInfo = data
        },

        // 移除state中的資料
        user_remove_info(state) {
            state.userInfo = []
            // 移除local資料
            localStorage.removeItem('userInfo')
        },

    },

});

export default store