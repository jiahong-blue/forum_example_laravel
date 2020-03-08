<template>
<div class="container">
    <div class="py-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <li class="breadcrumb-item active">{{subject}}</li>
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
            <router-link class="btn btn-primary float-right" :to="{name: 'TopicCreate', params: {subject: subject, board_id: board_id}}">發帖</router-link>
        </div>
    <div class="p-2 mb-0 bg-primary text-white"><h3>{{ this.subject }}</h3></div>
        <div v-for="item in test" class="card" :key="item.id">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <router-link :to="{ name: 'topic', params: { topic_id: item.id, title: item.title, subject: $route.params.subject, board_id: board_id } }">{{item.title}}</router-link>
                    </div>
                    <div class="col-6">
                        <span class="row">最新回覆: {{item.last_post[0].message}}</span>
                        <span class="row">{{item.updated_at}}</span>
                    </div>
                    <div class="col">
                        <span class="row">發帖人:{{item.user_name}}</span>
                        <span class="row">{{item.created_at}}</span>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['board_id', 'subject'],
    data() {
        return {
            board_data: [],
            pagination: {},
        }
    },
    computed: {
        test() { 
            return this.board_data.map(function(i) 
                {
                    i.last_post[0].message = i.last_post[0].message.substr(0, 10) + '......'; 
                    return i;
                }) 
        },

    },
    created() {
        this.getData();
    },
    methods: {
        getData(page_url) {
            page_url = page_url || `/api/board/${this.$route.params.board_id}`
            
            axios.get(page_url).then((res) => {
                this.board_data = res.data.data;
                this.makePagination(res.data.meta, res.data.links);
            })
            .catch((e) => {console.log(e)})
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
    },
    
}
</script>