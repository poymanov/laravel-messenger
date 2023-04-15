<script setup>

import {usePage} from "@inertiajs/vue3";
import MessageItem from "@/Components/Chat/MessageItem.vue";

defineProps({
    messages: {
        type: Array,
        required: true
    }
});

const currentAuthUserId = usePage().props.auth.user.id;

</script>

<template>
    <div
        v-for="message in messages"
        class="flex items-center group"
        :class="{'flex-row-reverse': currentAuthUserId === message.sender_user_id}"
    >
        <MessageItem :message="message" />
    </div>
</template>
