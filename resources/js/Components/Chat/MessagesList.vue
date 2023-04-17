<script setup>

import {usePage} from "@inertiajs/vue3";
import MessageItem from "@/Components/Chat/MessageItem.vue";

defineProps({
    messages: {
        type: Object,
        required: true
    }
});

const currentAuthUserId = usePage().props.auth.user.id;

</script>

<template>
    <template v-for="(data, name) in messages" :key="name">
        <p class="p-4 text-center text-gray-500">{{ data.title }}</p>

        <div
            v-for="message in data.messages"
            :key="message.id"
            class="flex items-center group"
            :class="{'flex-row-reverse': currentAuthUserId === message.sender_user_id}"
        >
            <MessageItem :message="message"/>
        </div>
    </template>
</template>
