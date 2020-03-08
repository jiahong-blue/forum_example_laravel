import Vue from 'vue'
import VueRouter from "vue-router"
import Home from "./components/HomeComponent.vue"
import Board from "./components/BoardsComponent.vue"
import Topic from "./components/TopicComponent.vue"
import PostEdit from "./components/PostEditComponent.vue"
import PostCreate from "./components/PostCreateComponent.vue"
import TopicEdit from "./components/TopicEditComponent.vue"
import TopicCreate from "./components/TopicCreateComponent.vue"
import Login from "./components/LoginComponent.vue"
import Register from "./components/RegisterComponent.vue"
import store from "./store"

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history', // 預設hashtag會有#，例如http:://example.com/#/
    routes: [
        {
            path:'/login',
            name: 'login',
            component: Login
        },
        {
            path:'/register',
            name: 'register',
            component: Register
        },
        {
            path: '/',
            name: 'home',
            component: Home, 
            props: true
        },
        {
            path: '/board/:board_id',
            name: 'board',
            component: Board,
            props: true
        },
        {
            path: '/topic/:topic_id',
            name: 'topic',
            component: Topic,
            props: true
        },
        {
            path: '/topic/edit/:post_id',
            name: 'TopicEit',
            component: TopicEdit,
            props: true,
            meta: { requiresAuth: true }
        },
        {
            path: '/topic/create',
            name: 'TopicCreate',
            component: TopicCreate,
            props: true,
            meta: { requiresAuth: true }
        },
        {
            path: '/post/edit/:post_id',
            name: 'PostEdit',
            component: PostEdit,
            props: true,
            meta: { requiresAuth: true }
        },
        {
            path: '/post/create',
            name: 'PostCreate',
            component: PostCreate,
            props: true,
            meta: { requiresAuth: true }
        },
        {
            path: '*',
            redirect: '/',
        },
    ],
});

router.beforeEach((to, from, next) => {
    // to:進入前; from:離開的地方; next:進入
    // 確認meta底下的資料，判定是否需要登入
    if(to.matched.some(route => route.meta.requiresAuth)) {
        // 判定是否登入
        if(store.state.userInfo.token) {
            next();

        } else {
            next({ name: 'login' })
        }

    } else {
        // 不須登入，下一頁
        next();
    }

});


export default router

