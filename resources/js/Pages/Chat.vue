
<template>
<!-- <Head title="Welcome" /> -->

    <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        <Link v-if="user" :href="route('chat')" class="text-sm text-gray-700 dark:text-gray-500 underline">chat</Link>

        <template v-else>
            <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</Link>

            <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</Link>
        </template>
    </div>
    <Link :href="route('top')" class="text-sm text-gray-700 dark:text-gray-500 underline">topに戻る</Link>



    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        このページはXSSが可能なページになっています。練習として悪意を持った誘導のコメントを書いてみましょう。
    </h2>
    <div class='content'>
        <div class='form'>
            <div>メッセージを打ち込んでください。</div>
            <textarea v-model="body"></textarea>
                <br>
            <button type="button" v-on:click="send()">送信</button>
        </div>
        <div class='indicate'>
            <div class="message" v-for="m in messages" :key="m.id">
                <span v-text="m.user_id ?`ユーザー名：${m.user.name}` : 'ユーザー名：名無し'"></span>
                <span class='ml-3' v-text="`作成日時：${m.created_at}`"></span>
                <br>
                <span v-html="m.body"></span> <!-- v-htmlをすることで、XSSが可能になっています。 -->
            </div>
        </div>
    </div>
    <Pagination class="mt-6 pb-6 pagination-main" :links="pager.links" />
</template>



<script>
import { computed } from 'vue'
import { usePage,Link,Head } from '@inertiajs/inertia-vue3'
import Pagination from '@/Components/Pagination.vue'
import AppLayout from '@/Layouts/AppLayout.vue';

export default {
    components: {
        Pagination,
        AppLayout,
        Link,
        Head,
    },
    props: {
        messages: Object,
        pager: Object,
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
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
h2{
    margin-top:50px;
    text-align: center;
}
.content{
    display:flex;
    margin-top:50px;
}
.form{
    margin-left:100px;
    margin-right:100px;
    width:30vw;
}

.indicate{
    width:70vw;
}
.message{
    margin-bottom:30px;
    padding-bottom:30px;
    border-bottom:1px solid;
}

.pagination-main{

}

</style>
