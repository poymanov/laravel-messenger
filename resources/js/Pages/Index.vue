<script setup>
import MessengerLayout from '@/Layouts/MessengerLayout.vue';

import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Index" />

    <MessengerLayout>
        <div class="chat-header px-6 py-4 flex flex-row border-l border-gray-200 flex-none justify-between items-center shadow">
            <div class="flex">
                <div class="w-12 h-12 mr-4 relative flex flex-shrink-0">

                </div>
            </div>

            <div class="flex">

            </div>
        </div>
        <div class="chat-body p-4 flex-1 overflow-y-scroll">
            <p class="font-bold text-black">Select a chat to start messaging</p>
        </div>
    </MessengerLayout>
</template>
