<template>
    <div class="container">
        <div class="py-2">
            <div v-if="res_message != ''" class="alert alert-success" role="alert">{{res_message}}</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                    <li class="breadcrumb-item"><router-link :to="{ name: 'board', params: { board_id: this.board_id, subject: this.subject }}" class="text-decoration-none">{{subject}}</router-link></li>
                    <li class="breadcrumb-item active">{{title}}</li>
                </ol>
            </nav>
            <div class="clearfix">
                <ul class="pagination float-left">
                    <li v-if="pagination.prev_page_url !== null" class="page-item"><button class="page-link"  v-on:click="getData(pagination.first_url)">first</button></li>
                    <li v-bind:class="[{disabled: !pagination.prev_page_url }]" class="page-item"><button class="page-link"  v-on:click="getData(pagination.prev_page_url)">Previous</button></li>
                    <li class="page-item disabled"><a class="page-link" href="javascript:void;">{{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                    <li v-bind:class="[{disabled: !pagination.next_page_url }]" class="page-item"><button class="page-link"  v-on:click="getData(pagination.next_page_url)">Next</button></li>
                    <li v-if="pagination.next_page_url !== null" class="page-item"><button class="page-link"  v-on:click="getData(pagination.last_url)">Last</button></li>
                </ul>
                <router-link class="btn btn-primary float-right" :to="{name: 'PostCreate', params: {board_id: this.board_id, subject: this.subject, topic_id: this.topic_id, title: this.title}}">回覆</router-link>
            </div>
            
            <div class="p-2 mb-0 bg-primary text-white"><h3>{{this.title}}</h3></div>
            <div v-for="item in topic_data" class="card" :key="item.id">
                <div class="card-body">
                    <div class="row" style="min-height:10rem">
                        <div class="col-4">
                            {{item.user_name}}
                        </div>
                        <!-- 判斷是否刪除 -->
                        <div v-if="item.show_on === 1" class="col-8">{{item.message}}</div>
                        <div v-else class="col-8 text-danger">已刪除</div>
                    </div>
                </div>

                <div class="footer text-right">
                    {{item.update_at}}
                    <div v-if="userInfo.id == item.user_id && item.show_on === 1">
                        <router-link class="btn btn-primary" :to="{name: 'PostEdit', params: {post_id: item.id, topic_id: item.topic_id, board_id: board_id, subject: subject, title: title}}" >編輯</router-link>
                        <button v-on:click="deleteData(item.id)" class="btn btn-danger">刪除</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['topic_id', 'title', 'subject', 'board_id'],
    data() {
        return {
            topic_data: [],
            pagination: {},
            res_message: '',
            }
    },
    computed: {
        userInfo() {
            return this.$store.state.userInfo
        },
    },
    methods: {
        getData(apiUrl) {
            apiUrl = apiUrl || `/api/topics/${this.$route.params.topic_id}`
            axios.get(apiUrl).then(res => {
                this.topic_data = res.data.data;
                this.makePagination(res.data.meta, res.data.links);

            }).catch(e => console.log(e));
        },
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev,
                first_url: links.first,
                last_url: links.last
            };

            this.pagination = pagination;

        },
        deleteData(id) {
            if(confirm('是否要刪除?')) {
                axios.delete(`/api/post/${id}`).then(res => {
                    alert('已刪除');
                    this.$data.topic_data.map(x => {x.id === id ? x.show_on = 0: x})
                }).catch(e => console.log(e)) 
            } 
        }
    },
    // 掛到el上時向後端與資料
    mounted() {
        this.getData();
        this.res_message = this.$route.params.res_message || '';
    }
}
</script>