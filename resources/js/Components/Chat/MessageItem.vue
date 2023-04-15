<script setup>

import {usePage} from "@inertiajs/vue3";

const props = defineProps({
    message: {
        type: Object,
        required: true
    }
});

const currentAuthUserId = usePage().props.auth.user.id;
const isCurrentUserSender = currentAuthUserId === props.message.sender_user_id;

</script>

<template>
    <p
        class="px-6 py-3 rounded-full max-w-xs lg:max-w-md text-gray-200 mb-2"
        :class="{'bg-gray-800': !isCurrentUserSender, 'bg-blue-700': isCurrentUserSender}"
    >{{ message.text }} </p>
</template>
