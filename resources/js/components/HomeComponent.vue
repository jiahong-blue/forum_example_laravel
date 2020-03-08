<template>
    <div class="container">
        <!-- 綜合 -->
        <div class="py-2">
            <div class="p-2 mb-0 bg-primary text-white"><h3>綜合區</h3></div>
            <div v-for="item in class_chat" class="card" :key="item.id">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <router-link :to="{ name: 'board', params: { board_id: item.id, subject: item.subject }}" class="text-decoration-none">{{item.subject}}</router-link>
                        </div>
                        <div class="col-6">{{item.description}}</div>
                        <div class="col">{{item.topic_count}}</div>  
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 手機 -->
        <div class="py-2">
            <div class="p-2 mb-0 bg-primary text-white"><h3>手機區</h3></div>
            <div v-for="item in class_mobile" class="card" :key="item.id">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <router-link :to="{ name: 'board', params: { board_id: item.id, subject: item.subject }}">{{item.subject}}</router-link>
                        </div>
                        <div class="col-6">{{item.description}}</div>
                        <div class="col">{{item.topic_count}}</div>  
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
            boards_data: [],
        }
    },
    computed: {
        // 以下為將資料分類
        // 綜合
        class_chat() {
            return this.boards_data.filter(item => {
                return item.board_type === 1
            });
        },
        // 手機
        class_mobile() {
            return this.boards_data.filter((item) => {
                return item.board_type === 2
            });
        },
    },
    methods: {
        // 取得資料
        getData() {
            axios.get('/api/boards').then((res) => {
                this.boards_data = res.data.data;
            })
            .catch((e) => {console.log(e)})
        },

        // 確認是否登入
        checkLogin() {
            this.$store.dispatch('USER_CHECK_LOGIN')
        }
    },
    created() {
        this.getData();
    },
    mounted() {
        this.checkLogin();
    },


}
</script>
