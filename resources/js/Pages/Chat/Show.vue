<script setup>
import MessengerLayout from '@/Layouts/MessengerLayout.vue';

import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Chat"/>

    <MessengerLayout>
        <div class="chat-body p-4 flex-1 overflow-y-scroll">
            <p class="font-bold">Chat with user</p>
        </div>
    </MessengerLayout>
</template>
