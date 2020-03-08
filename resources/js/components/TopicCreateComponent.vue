<template>
    <div class="container">
        <div class="py-2">
            <div v-if="res_message != ''" class="alert alert-danger" role="alert">{{res_message}}</div>
            <form @submit.prevent="selectCreateOrEdit">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>標題</label>
                            <input class="form-control" v-model.trim="title">
                        </div>
                        <div class="form-group">
                            <label>內容</label>
                            <textarea class="form-control" v-model.trim="message" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">確認</button>
                        <router-link class="btn btn-danger" :to="{ name: 'board', params: { board_id: this.board_id, subject: this.subject }}">取消</router-link>
                    </div>
                </div> 
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props:['topic_id', 'subject', 'board_id'],
    data() {
        return {
            data: [],
            message: '',
            title: '',
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
        // 取資料
        getData() {

        },
        // 判斷要新建還是編輯
        selectCreateOrEdit() {
            // 若topic_id存在表示為編輯，若不存在則為新建
            if(this.topic_id) {
                this.editTopic();
            } else {
                this.createTopic();
            }
        },
        // 建資料
        createTopic() {
            let data = {user_id: this.userInfo.id, board_id: this.board_id, 
                        title: this.title, message: this.message}
            let header = { headers: { Authorization: "Bearer " + this.userInfo.token } }
            axios.post('/api/topic', data, header).then(res => {
                this.$router.push({ name: 'topic', params: { topic_id: res.data.data.id, title: this.title, 
                                                           subject: this.subject, board_id: this.board_id } })
            }).catch(e => console.log(e))
            
        },
        // 編輯資料
        editTopic() {
            console.log('edit')

        },
    },
}
</script>
