

<template>
    <div class='content'>
        <div class='form'>
            <div>メッセージを打ち込んでください</div>
            <textarea v-model="body"></textarea>
                <br>
            <button type="button" v-on:click="send()">送信</button>
        </div>
        <div class='indicate'>
            <div class="message" v-for="m in messages" :key="m.id">
                <span v-text="m.user_id ?`${m.user.name}` : '名無し'"></span>
                <br>
                <span v-text="m.body"></span>
            </div>
        </div>
    </div>
    <Pagination class="mt-6" :links="pager.links" />
</template>



<script>
import { computed } from 'vue'
import { usePage,Link } from '@inertiajs/inertia-vue3'
import Pagination from '@/Components/Pagination.vue'


export default {
    components: {
        Pagination
    },
    props: {
      messages: Object,
      pager: Object,
    },
    setup() {
        const user = computed(() => usePage().props.value.auth.user)
        const movePage = (page) => {window.location.href = `./subscriptions?page=${page}`}
        return { user, movePage}
    },
    methods: {
        send() {
            const formData = new FormData()
            formData.append('body',this.body)

            this.$inertia.post('/chat', formData, {
                onSuccess: () => (
                    this.body = ''
                ),
            })
        },
    },
}
</script>

<style lang="css" scoped>
.content{
    display:flex
}

.content{
    margin-top:100px;
}
.form{
margin-left:100px;
margin-right:100px;
}

.indicate{

}
.message{
    margin-bottom:30px;
}

</style>
