<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Inertia } from '@inertiajs/inertia';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <Head title="Welcome" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</Link>
                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</Link>
            </template>
        </div>
        <div v-if="$page.props.user">
            <Link :href="route('chat')" class="text-base text-gray-700 dark:text-gray-500 underline pl-10">チャット（XSSの練習）をする</Link>
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex underline "><a href="/search_messages" >検索（SQLインジェクションの練習）をする</a></div>
            <form method="POST" @submit.prevent="logout" class="pl-6"><ResponsiveNavLink as="button">Log Outをする</ResponsiveNavLink></form>
            <div>※注意:このサイトで起きたトラブルに関して作者は一切の責任を負いかねます。</div>
            <div class="pl-10">特にアカウントを登録する際は他人に閲覧される前提になるので、使い捨てのパスワードを登録してください。</div>
            <div class="pl-10">もし興味があるけど不安という方は<a>こちらのブログ</a>で内容だけご確認ください。</div>
        </div>
        <div v-else>
                <Link :href="route('chat')" class="text-base text-gray-700 dark:text-gray-500 underline pl-10">Log inしないでチャット（ハッキングの練習）をする</Link>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex underline"><a href="/search_messages" >Log inしないでチャット検索（SQLインジェクションの練習）をする</a></div>
        </div>
    </div>
</template>
