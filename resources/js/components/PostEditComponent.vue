<template>
    <div class="container">
        <div class="py-2">
            <form @submit.prevent="updateMessage">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control" v-model="data.message" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">確認</button>
                        <router-link class="btn btn-danger" :to="{ name: 'topic', 
                               params: { topic_id: this.topic_id, title: this.title, 
                                         subject: this.subject, board_id: this.board_id } }">
                        取消
                        </router-link>
                    </div>
                </div> 
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props:['topic_id', 'title', 'subject', 'board_id'],
    data() {
        return {
            data: [],
        }
    },
    computed: {
        // 從state取得user資料
        userInfo() {
            return this.$store.state.userInfo
        }
    },
    methods: {
        // 取資料
        getMessage() {
            axios.get(`/api/post/${this.$route.params.post_id}`).then(res => {
                this.data = res.data.data;

            }).catch(e => {
                console.log(e);
            });
        },
        // 更新資料
        updateMessage() {
            let postData = { id: this.data.id, topic_id: this.data.topic_id, 
                             message: this.data.message, user_id: this.data.user_id }

            let header = { headers: { Authorization: "Bearer " + this.userInfo.token } }
            axios.put('/api/post', postData, header)
                 .then(res => { this.$router.push({ name: 'topic', 
                                    params: { topic_id: this.topic_id, title: this.title, 
                                                subject: this.subject, board_id: this.board_id }
                                    })
            })

        },
    },
    created() {
        this.getMessage();
    },

}
</script>

<style>

</style>