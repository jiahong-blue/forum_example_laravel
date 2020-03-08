<template>
    <div class="container">
        <div class="py-2">
            <div v-if="res_message != ''" class="alert alert-danger" role="alert">{{res_message}}</div>
            <form @submit.prevent="createReply">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>內容</label>
                            <textarea class="form-control" v-model="message" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">確認</button>
                        <router-link class="btn btn-danger" :to="{ name: 'topic', params: { topic_id: this.topic_id, title: this.title, subject: this.subject, board_id: this.board_id } }">取消</router-link>
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
            message: '',
            res_message: '',
        }
    },
    computed: {
        // 從state取得user資料
        userInfo() {
            return this.$store.state.userInfo
        }
    },

    methods: {
        // 建資料
        createReply() {
            axios.post('/api/post', {topic_id: this.topic_id, message: this.message, user_id: this.userInfo.id}, 
                        { headers: { Authorization: "Bearer " + this.userInfo.token } })
                 .then(res => {
                        // 若有錯誤，就更動底下的res_message
                        if(res.data.error) {
                            this.res_message = res.data.error
                        } else {
                            // 若成功就攜帶訊息回topic
                            this.$router.push({ name: 'topic', 
                                                params: { topic_id: this.topic_id, title: this.title, 
                                                          subject: this.subject, board_id: this.board_id,
                                                           res_message: res.data.success }
                                            })
                        }
                        
                    }).catch(e => console.log(e));
        },
    },
}
</script>
